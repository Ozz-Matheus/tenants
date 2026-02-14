<?php

namespace App\Filament\Dashboard\Resources\Headquarters\Pages;

use App\Filament\Dashboard\Resources\Headquarters\HeadquarterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeadquarters extends ListRecords
{
    protected static string $resource = HeadquarterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
