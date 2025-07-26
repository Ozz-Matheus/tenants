<?php

namespace App\Filament\Dashboard\Resources\ProcessRiskResource\Pages;

use App\Filament\Dashboard\Resources\ProcessRiskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcessRisk extends EditRecord
{
    protected static string $resource = ProcessRiskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
