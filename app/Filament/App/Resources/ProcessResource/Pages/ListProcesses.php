<?php

namespace App\Filament\App\Resources\ProcessResource\Pages;

use App\Filament\App\Resources\ProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProcesses extends ListRecords
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
