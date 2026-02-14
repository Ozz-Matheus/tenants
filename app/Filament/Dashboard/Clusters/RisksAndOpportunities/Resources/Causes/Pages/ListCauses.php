<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\CauseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCauses extends ListRecords
{
    protected static string $resource = CauseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
