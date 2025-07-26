<?php

namespace App\Filament\Dashboard\Resources\AuditCriteriaResource\Pages;

use App\Filament\Dashboard\Resources\AuditCriteriaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuditCriteria extends EditRecord
{
    protected static string $resource = AuditCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
