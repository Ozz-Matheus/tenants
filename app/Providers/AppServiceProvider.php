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
            if ($user = auth()->user()) {
                $panelId = Filament::getCurrentPanel()->getId();
                $cacheKey = "spatie.permission.cache.{$panelId}.user.{$user->getAuthIdentifier()}";

                // Esto evita lecturas obsoletas del cache anterior
                app(PermissionRegistrar::class)->forgetCachedPermissions();

                // Esto asegura un cache aislado por panel + user
                app(PermissionRegistrar::class)->cacheKey = $cacheKey;
            }
        });
    }
}
