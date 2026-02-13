<?php

namespace App\Providers;

use App\Models\Tenant;
use App\Observers\TenantObserver;
use App\Services\TenantStorageInitializer;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Stancl\Tenancy\Events\TenancyBootstrapped;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;

class HoldingtecServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //$this->configureLivewireTenancy();
        $this->configureTenancyObserversAndEvents();
        $this->configureFilamentAssets();
    }

    /**
     * Asegura que Livewire respete el contexto del Tenant en sus peticiones de actualización.
     */
    // private function configureLivewireTenancy(): void
    // {
    //     $centralDomains = config('tenancy.central_domains', []);

    //     if (! in_array(request()->getHost(), $centralDomains)) {
    //         Livewire::setUpdateRoute(function ($handle) {
    //             return Route::post('/livewire/update', $handle)
    //                 ->middleware([
    //                     'web',
    //                     InitializeTenancyBySubdomain::class,
    //                 ]);
    //         });
    //     }
    // }

    /**
     * Registra los observadores de modelos y eventos de Stancl/Tenancy.
     */
    private function configureTenancyObserversAndEvents(): void
    {

        // Inicializador de Storage al cargar el Tenant
        Event::listen(TenancyBootstrapped::class, function ($event) {
            $tenantId = tenant()?->getTenantKey();

            if (! $tenantId) {
                return;
            }

            app(TenantStorageInitializer::class)->ensureStorageStructure($tenantId);
        });

        // Observador de limpieza de Storage para los Tenants
        Tenant::observe(TenantObserver::class);
    }

    /**
     * Registra los assets globales de Filament (CSS/JS personalizados).
     */
    private function configureFilamentAssets(): void
    {
        FilamentAsset::register([
            Css::make('holdingtec-app', asset('styles/holdingtec-app.css')),
        ]);
    }
}
