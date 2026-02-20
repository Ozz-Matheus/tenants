<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\ControlResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListControls extends ListRecords
{
    protected static string $resource = ControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::PlusCircle),
        ];
    }
}
