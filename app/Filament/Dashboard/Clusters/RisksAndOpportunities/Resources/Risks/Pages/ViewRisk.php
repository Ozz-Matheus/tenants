<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\RiskResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRisk extends ViewRecord
{
    protected static string $resource = RiskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
