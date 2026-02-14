<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\RiskResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRisk extends EditRecord
{
    protected static string $resource = RiskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
