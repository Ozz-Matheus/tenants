<?php

namespace App\Services;

use App\Models\Doc;
use App\Models\DocType;
use App\Models\Headquarter;
use App\Models\Subprocess;
use Illuminate\Support\Facades\DB;

class DocService
{
    /**
     * Generate document code.
     */
    public function generateCode($docTypeId, $subprocessId, $headquarterId): string
    {

        $headquarterId = $headquarterId ?? auth()->user()->headquarter_id;

        return DB::transaction(function () use ($docTypeId, $subprocessId, $headquarterId) {
            $type = DocType::lockForUpdate()->findOrFail($docTypeId);
            $subprocess = Subprocess::lockForUpdate()->findOrFail($subprocessId);
            $headquarter = Headquarter::lockForUpdate()->findOrFail($headquarterId);

            $count = Doc::where('doc_type_id', $docTypeId)
                ->where('subprocess_id', $subprocessId)
                ->where('headquarter_id', $headquarterId)
                ->lockForUpdate()
                ->count();

            $consecutive = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

            return "{$type->acronym}-{$subprocess->acronym}-{$consecutive}-{$headquarter->acronym}";
        });
    }
}
