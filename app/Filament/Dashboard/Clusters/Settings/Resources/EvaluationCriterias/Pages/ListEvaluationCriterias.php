<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Pages;

use App\Enums\CriteriaTypeEnum;
use App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\EvaluationCriteriaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListEvaluationCriterias extends ListRecords
{
    protected static string $resource = EvaluationCriteriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        foreach (CriteriaTypeEnum::cases() as $criteriaType) {
            $tabs[$criteriaType->value] = Tab::make($criteriaType->getLabel())
                ->modifyQueryUsing(fn ($query) => $query->where('criteria_type', $criteriaType));
        }

        return $tabs;
    }
}
