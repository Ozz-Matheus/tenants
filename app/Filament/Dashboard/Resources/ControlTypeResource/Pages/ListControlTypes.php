<?php

namespace App\Filament\Dashboard\Resources\ControlTypeResource\Pages;

use App\Filament\Dashboard\Resources\ControlTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControlTypes extends ListRecords
{
    protected static string $resource = ControlTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
