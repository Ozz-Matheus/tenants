<?php

namespace App\Filament\Dashboard\Resources\Audit\Pages;

use App\Filament\Dashboard\Resources\Audit\AuditResource;
use Filament\Resources\Pages\ListRecords;

class ListAudits extends ListRecords
{
    protected static string $resource = AuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
