<?php

namespace App\Filament\Dashboard\Resources\ActionEndingResource\Pages;

use App\Filament\Dashboard\Resources\ActionEndingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActionEndings extends ListRecords
{
    protected static string $resource = ActionEndingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
