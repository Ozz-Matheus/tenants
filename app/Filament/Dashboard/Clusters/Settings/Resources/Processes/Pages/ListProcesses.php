<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\ProcessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListProcesses extends ListRecords
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::PlusCircle),
        ];
    }
}
