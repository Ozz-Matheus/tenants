<?php

namespace App\Filament\Dashboard\Resources\ProcessAuditResource\Pages;

use App\Filament\Dashboard\Resources\ProcessAuditResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAudits extends ListRecords
{
    protected static string $resource = ProcessAuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
