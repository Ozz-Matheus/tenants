<?php

namespace App\Filament\Dashboard\Resources\ControlResource\Pages;

use App\Filament\Dashboard\Resources\ControlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControls extends ListRecords
{
    protected static string $resource = ControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
