<?php

namespace App\Filament\Dashboard\Resources\DocEndingResource\Pages;

use App\Filament\Dashboard\Resources\DocEndingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocEndings extends ListRecords
{
    protected static string $resource = DocEndingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
