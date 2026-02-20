<?php

namespace App\Services;

use App\Models\Headquarter;
use App\Models\Risk;
use App\Models\Subprocess;
use Illuminate\Support\Facades\DB;

/**
 * Servicio para riesgos
 */
class RiskService
{
    // Generar código de riesgo
    public function generateCode($subprocessId, $headquarterId): string
    {
        $headquarterId = $headquarterId ?? auth()->user()->headquarter_id;

        return DB::transaction(function () use ($subprocessId, $headquarterId) {

            $subprocess = Subprocess::lockForUpdate()->findOrFail($subprocessId);
            $headquarter = Headquarter::lockForUpdate()->findOrFail($headquarterId);

            $count = Risk::where('subprocess_id', $subprocessId)
                ->where('headquarter_id', $headquarterId)
                ->lockForUpdate()
                ->count();

            $consecutive = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

            return "R-{$subprocess->acronym}-{$consecutive}-{$headquarter->acronym}";
        });
    }
}
