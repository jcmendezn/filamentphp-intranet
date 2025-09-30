<?php
namespace App\Filament\Support;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;

trait AuthorizesWidgetWithShield
{
    public static function canView(): bool
    {
        $user = Filament::auth()->user();

        
           // dd($user);
        return $user
            ? Gate::forUser($user)->allows('view', static::class)
            : false;

            
    }
}






