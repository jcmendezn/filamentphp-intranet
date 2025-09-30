<?php

use Illuminate\Support\Facades\Route;
use BladeUI\Icons\Factory as IconsFactory; // usa la fábrica, no el helper
use Illuminate\Support\Facades\App;


Route::get('/', fn () => view('welcome'));

if (app()->environment('local')) {
    // Debe devolver 'heroicon-o-user-group' si la traducción de Shield se carga
    Route::get('/__t', fn () => __('filament-shield::filament-shield.nav.role.icon'));

    // Ver los aliases que definiste en config/blade-icons.php
    Route::get('/__aliases', fn () => config('blade-icons.aliases'));

    /* Renderiza el ícono usando la FÁBRICA (esto respeta los aliases)
    Route::get('/__icon', function (IconsFactory $icons) {
        return $icons->svg('filament-shield::filament-shield.nav.role.icon')->toHtml();
    });*/

    // (opcional) prueba directa del heroicon
    Route::get('/__icon2', function (IconsFactory $icons) {
        return $icons->svg('heroicon-o-user-group')->toHtml();
    });


Route::get('/__t-en', function () {
    App::setLocale('en');
    return __('filament-shield::filament-shield.nav.role.icon'); // también debe devolver "heroicon-o-user-group" o "heroicon-o-shield-check"
});

/////////////////////////////////////////////////////////////////////////////////
Route::get('/__icon', function (IconsFactory $icons) {
    $key = 'filament-shield::filament-shield.nav.role.icon';

    // 1) intenta alias en config/blade-icons.php
    $name = config("blade-icons.aliases.$key");

    // 2) si no hay alias, intenta por traducción (fallback a 'en' funciona)
    if (! $name || $name === $key) {
        $name = __($key);
    }

    // 3) por si la traducción tampoco resolviera, último fallback explícito
    if (! is_string($name) || $name === $key) {
        $name = 'heroicon-o-user-group';
    }

    return $icons->svg($name)->toHtml();
});

}
