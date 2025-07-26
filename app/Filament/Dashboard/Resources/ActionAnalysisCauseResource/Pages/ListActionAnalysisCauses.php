<?php

namespace App\Filament\Dashboard\Resources\ActionAnalysisCauseResource\Pages;

use App\Filament\Dashboard\Resources\ActionAnalysisCauseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActionAnalysisCauses extends ListRecords
{
    protected static string $resource = ActionAnalysisCauseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
