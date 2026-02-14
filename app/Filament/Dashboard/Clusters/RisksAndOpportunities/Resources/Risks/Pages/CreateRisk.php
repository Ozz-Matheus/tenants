<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\RiskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRisk extends CreateRecord
{
    protected static string $resource = RiskResource::class;
}
