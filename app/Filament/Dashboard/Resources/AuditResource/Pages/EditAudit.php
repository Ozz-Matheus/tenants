<?php

namespace App\Filament\Dashboard\Resources\AuditResource\Pages;

use App\Filament\Dashboard\Resources\AuditResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAudit extends EditRecord
{
    protected static string $resource = AuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
