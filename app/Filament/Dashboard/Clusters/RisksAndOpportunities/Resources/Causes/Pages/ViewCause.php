<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\CauseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCause extends ViewRecord
{
    protected static string $resource = CauseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
