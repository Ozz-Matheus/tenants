<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\RiskResource;
use App\Services\RiskService;
use Filament\Resources\Pages\CreateRecord;

class CreateRisk extends CreateRecord
{
    protected static string $resource = RiskResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['classification_code'] = app(RiskService::class)->generateCode($data['subprocess_id'], $data['headquarter_id'] ?? null);
        // $data['risk_control_general_qualification_id'] = RiskControlQualification::where('context', 'min')->firstOrFail()->id;
        $data['residual_impact_id'] = $data['inherent_impact_id'];
        $data['residual_probability_id'] = $data['inherent_probability_id'];
        $data['residual_level_id'] = $data['inherent_level_id'];

        $data['created_by_id'] = auth()->id();
        $data['updated_by_id'] = auth()->id();

        // dd($data);
        return $data;
    }
}
