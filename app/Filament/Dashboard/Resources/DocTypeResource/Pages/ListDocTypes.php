<?php

namespace App\Filament\Dashboard\Resources\DocTypeResource\Pages;

use App\Filament\Dashboard\Resources\DocTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocTypes extends ListRecords
{
    protected static string $resource = DocTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
