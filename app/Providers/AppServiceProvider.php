<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;
use Stancl\Tenancy\Events\TenancyBootstrapped;

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

        // Este bloque crea automáticamente el directorio para el tenant
        \Event::listen(TenancyBootstrapped::class, function ($event) {
            $tenantId = tenant()?->getTenantKey();

            $suffixBase = config('tenancy.filesystem.suffix_base');

            if (! $tenantId) {
                return;
            }

            $tenantStoragePath = storage_path();

            if (! File::exists($tenantStoragePath)) {
                File::makeDirectory($tenantStoragePath.'/app/public', 0777, true);
                File::makeDirectory($tenantStoragePath.'/framework/cache', 0777, true);

                symlink("{$tenantStoragePath}/app/public", public_path("{$suffixBase}{$tenantId}"));
            }
        });

    }
}
