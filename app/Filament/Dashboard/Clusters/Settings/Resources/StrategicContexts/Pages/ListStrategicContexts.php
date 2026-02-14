<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\StrategicContextResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStrategicContexts extends ListRecords
{
    protected static string $resource = StrategicContextResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
