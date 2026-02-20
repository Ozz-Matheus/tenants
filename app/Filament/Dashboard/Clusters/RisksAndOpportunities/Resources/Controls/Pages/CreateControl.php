<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages;

use App\Enums\EffectivenessLevelEnum;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\ControlResource;
use Filament\Resources\Pages\CreateRecord;

class CreateControl extends CreateRecord
{
    protected static string $resource = ControlResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = auth()->id();

        $data['effectiveness_rating'] = 0;
        $data['effectiveness_level'] = EffectivenessLevelEnum::INEFFECTIVE;
        $data['created_by_id'] = $userId;
        $data['updated_by_id'] = $userId;

        return $data;
    }
}
