<?php

namespace App\Providers\Filament;

use App\Filament\Dashboard\Resources\ActionResource\Widgets\ActionStatsOverview;
use App\Filament\Dashboard\Resources\ActionResource\Widgets\ActionStatusChart;
use App\Filament\Dashboard\Resources\ActionTaskResource\Widgets\UserTaskList;
use App\Filament\Dashboard\Resources\DocResource\Widgets\DocStatsOverview;
use App\Filament\Dashboard\Resources\DocResource\Widgets\DocStatusesChart;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\UserMenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TomatoPHP\FilamentTenancy\FilamentTenancyAppPlugin;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        FilamentColor::register([
            'primary' => Color::hex(config('filament-colors.primary.hex')),
            'secondary' => Color::hex(config('filament-colors.secondary.hex')),
            'indigo' => Color::hex(config('filament-colors.indigo.hex')),
            'success' => Color::hex(config('filament-colors.success.hex')),
            'danger' => Color::hex(config('filament-colors.danger.hex')),
            'warning' => Color::hex(config('filament-colors.warning.hex')),
            'darkextra' => Color::hex(config('filament-colors.darkextra.hex')),

        ]);

        return $panel
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->colors([
                'primary' => Color::hex(config('filament-colors.primary.hex')),
            ])
            ->favicon(asset('images/favicon.png'))
            ->brandLogo(asset('images/record-manager-logo.svg'))
            ->darkModeBrandLogo(asset('images/record-manager-logo-dark.svg'))
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Dashboard/Resources'), for: 'App\\Filament\\Dashboard\\Resources')
            ->discoverPages(in: app_path('Filament/Dashboard/Pages'), for: 'App\\Filament\\Dashboard\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Dashboard/Widgets'), for: 'App\\Filament\\Dashboard\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                DocStatsOverview::class,
                DocStatusesChart::class,
                ActionStatsOverview::class,
                ActionStatusChart::class,
                UserTaskList::class,
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
                FilamentTenancyAppPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->databaseNotifications()
            ->userMenuItems([
                // Subproceso
                UserMenuItem::make()
                    ->label(function () {
                        return auth()->user()?->leaderOfSubProcess()?->title;
                    })
                    ->icon('heroicon-o-puzzle-piece') // ícono para subproceso
                    ->url(null)
                    ->sort(2)
                    ->hidden(fn () => ! auth()->user()?->leaderOfSubProcess() ||
                        auth()->user()?->hasRole('super_admin') ||
                        auth()->user()?->hasRole('admin')
                    ),
                // Proceso
                UserMenuItem::make()
                    ->label(function () {
                        $subProcess = auth()->user()?->leaderOfSubProcess();

                        return $subProcess?->process?->title;
                    })
                    ->icon('heroicon-o-rectangle-group') // ícono para proceso
                    ->url(null)
                    ->sort(1)
                    ->hidden(fn () => ! auth()->user()?->leaderOfSubProcess() ||
                        auth()->user()?->hasRole('super_admin') ||
                        auth()->user()?->hasRole('admin')
                    ),
            ]);
    }
}
