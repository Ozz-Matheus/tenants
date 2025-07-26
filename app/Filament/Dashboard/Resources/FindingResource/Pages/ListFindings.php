<?php

namespace App\Filament\Dashboard\Resources\FindingResource\Pages;

use App\Filament\Dashboard\Resources\FindingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFindings extends ListRecords
{
    protected static string $resource = FindingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
