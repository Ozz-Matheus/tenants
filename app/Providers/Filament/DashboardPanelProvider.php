<?php

namespace App\Providers\Filament;

use App\Filament\Pages\FileViewer;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentColor;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Tapp\FilamentAuditing\FilamentAuditingPlugin;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {

        FilamentColor::register([
            'indigo' => Color::Indigo,
        ]);

        return $panel
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->favicon(asset('images/favicon.png'))
            ->brandLogo(asset('images/logo_claro.svg'))
            ->darkModeBrandLogo(asset('images/logo_oscuro.svg'))
            ->brandLogoHeight('3rem')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth(Width::Full)
            ->spa()
            ->spaUrlExceptions([
                '*/secure-files/*',
            ])
            ->unsavedChangesAlerts()
            ->readOnlyRelationManagersOnResourceViewPagesByDefault(false)
            ->discoverResources(in: app_path('Filament/Dashboard/Resources'), for: 'App\Filament\Dashboard\Resources')
            ->discoverPages(in: app_path('Filament/Dashboard/Pages'), for: 'App\Filament\Dashboard\Pages')
            ->discoverClusters(in: app_path('Filament/Dashboard/Clusters'), for: 'App\Filament\Dashboard\Clusters')
            ->pages([
                Dashboard::class,
                FileViewer::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Dashboard/Widgets'), for: 'App\Filament\Dashboard\Widgets')
            ->widgets([
                AccountWidget::class,
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
            ->middleware([
                'universal',
                InitializeTenancyBySubdomain::class,
                PreventAccessFromCentralDomains::class,
            ], isPersistent: true)
            ->plugins([
                FilamentShieldPlugin::make()
                    ->navigationSort(1)
                    ->navigationGroup(__('Role Management')),
                FilamentAuditingPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->databaseNotifications();
    }
}
