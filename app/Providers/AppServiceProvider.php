<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Lang;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1) Asegura que Laravel use tus overrides de traducciones de Shield
        Lang::addNamespace('filament-shield', resource_path('lang/vendor/filament-shield'));
        $this->loadTranslationsFrom(resource_path('lang/vendor/filament-shield'), 'filament-shield');

        // 2) Idiomas para el plugin de language switch (opcional)
        LanguageSwitch::configureUsing(fn (LanguageSwitch $s) => $s->locales(['es', 'en']));

        // 3) Forzar aliases de íconos para Shield en AMBOS lugares de config
        $aliases = [
            'filament-shield::filament-shield.nav.role.icon'        => 'heroicon-o-user-group',
            'filament-shield::filament-shield.nav.permission.icon'  => 'heroicon-o-key',

            // variantes sin el doble namespace por si algún punto del código las usa:
            'filament-shield.nav.role.icon'        => 'heroicon-o-user-group',
            'filament-shield.nav.permission.icon'  => 'heroicon-o-key',
        ];

        // Paquete nuevo de Blade Icons
        config()->set(
            'blade-icons.aliases',
            array_merge(config('blade-icons.aliases', []), $aliases)
        );

        // Algunos entornos/versions leen de esta otra clave
        config()->set(
            'blade-ui-kit.blade-icons.aliases',
            array_merge(config('blade-ui-kit.blade-icons.aliases', []), $aliases)
        );
    }
}
