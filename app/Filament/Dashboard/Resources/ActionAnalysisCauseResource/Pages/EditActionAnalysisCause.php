<?php

namespace App\Filament\Dashboard\Resources\ActionAnalysisCauseResource\Pages;

use App\Filament\Dashboard\Resources\ActionAnalysisCauseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActionAnalysisCause extends EditRecord
{
    protected static string $resource = ActionAnalysisCauseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
