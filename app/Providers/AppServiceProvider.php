<?php

namespace App\Providers;

use App\Services\TenantStorageInitializer;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;
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

        Gate::define('audit', function ($user, $resource) {
            return $user->hasRole('super_admin');
        });

        Gate::define('restoreAudit', function ($user, $resource) {
            return $user->hasRole('super_admin');
        });

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

            if (! $tenantId) {
                return;
            }

            app(TenantStorageInitializer::class)->ensureStorageStructure($tenantId);
        });

    }
}
