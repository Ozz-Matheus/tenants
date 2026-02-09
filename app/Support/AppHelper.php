<?php

namespace App\Support;

use Filament\Facades\Filament;
use Illuminate\Support\Str;

class AppHelper
{
    public static function getHomeUrl(): string
    {
        // 1. Centralizamos la lógica de decisión
        $panelId = in_array(request()->getHost(), config('tenancy.central_domains', []))
            ? 'admin'
            : 'dashboard';

        // 2. Intentamos obtener la ruta oficial del panel
        try {
            return Filament::getPanel($panelId)?->getUrl() ?? url("/{$panelId}");
        } catch (\Throwable) {
            // 3. Fallback silencioso: Si el panel no carga, devolvemos la URL manual
            // Esto evita romper la navegación del usuario.
            return url("/{$panelId}");
        }

    }

    /**
     * Genera la URL completa para un subdominio de tenant.
     */
    public static function getTenantUrl(?string $subdomain, string $path = '/dashboard'): ?string
    {
        if (blank($subdomain)) {
            return null;
        }

        $scheme = request()->getScheme();
        $centralDomain = config('holdingtec.central_domain');

        // Limpieza preventiva del path para evitar dobles slashes //
        $path = Str::start($path, '/');

        return "{$scheme}://{$subdomain}.{$centralDomain}{$path}";
    }
}
