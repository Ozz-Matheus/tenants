<?php

namespace App\Filament\Dashboard\Resources\Audit\Pages;

use App\Filament\Dashboard\Resources\Audit\AuditResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAudit extends ViewRecord
{
    protected static string $resource = AuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
