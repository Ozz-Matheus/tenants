<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            $user = auth()->user();

            if ($user) {
                // Forzar cache de permisos única por panel e ID
                $panelId = filament()->getCurrentPanel()->getId();
                app(PermissionRegistrar::class)->cacheKey = "spatie.permission.cache.{$panelId}.user.{$user->getAuthIdentifier()}";
            }
        });
    }
}
