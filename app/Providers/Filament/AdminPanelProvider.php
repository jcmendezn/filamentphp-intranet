<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
// use Filament\Pages\Dashboard; el de antes
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\UserChart;

use Filament\Pages\Dashboard;




class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->sidebarCollapsibleOnDesktop()
            ->renderHook('panels::body.start', function () {
            $id = filament()->getCurrentPanel()->getId();
            return "<script>(function(){try{var k='filament.$id.sidebar.isCollapsed';if(localStorage.getItem(k)===null){localStorage.setItem(k,'true');}}catch(e){}})();</script>";
            })            
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                //AccountWidget::class,
                //FilamentInfoWidget::class,
            ])
            /*
            ->discoverPages(in: app_path('Filament/Resources/Pages'), for: 'App\\Filament\\Resources\\Pages')
            ->pages([
                AdminDashboard::class,
            ])            
            */
            // 👇 REGISTRA explícitamente los widgets que quieres ver en el Dashboard
            ->widgets([
                StatsOverview::class,
                UserChart::class,
            ])            
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
        // …tus llamadas actuales (id, path, auth, resources, etc.)
         ->navigationGroups([
            // 1ro en el sidebar
            NavigationGroup::make()
                ->label('Employees Management')
                ->collapsed(true),

            // 2do en el sidebar
            NavigationGroup::make()
                ->label('System Management')
                ->collapsed(true),
        ]) 

        ;          
            


            
            
    }
}
