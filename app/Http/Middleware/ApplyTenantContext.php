<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ApplyTenantContext
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si ya se identificó un tenant, le decimos al generador de URLs
        if ($tenant = tenant()) {
            URL::defaults([
                'tenant' => $tenant->domains->first()?->domain,
            ]);
        }

        return $next($request);
    }
}
