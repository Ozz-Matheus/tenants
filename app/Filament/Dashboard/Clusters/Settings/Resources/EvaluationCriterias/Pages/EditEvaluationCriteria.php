<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\EvaluationCriteriaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEvaluationCriteria extends EditRecord
{
    protected static string $resource = EvaluationCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
