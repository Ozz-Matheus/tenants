<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Pages;

use App\Enums\CriteriaTypeEnum;
use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\ItemValueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListItemValues extends ListRecords
{
    protected static string $resource = ItemValueResource::class;

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
            if ($criteriaType === CriteriaTypeEnum::LEVEL) {
                continue;
            }

            $tabs[$criteriaType->value] = Tab::make($criteriaType->getLabel())
                ->modifyQueryUsing(fn ($query) => $query->where('item_criteria_type', $criteriaType));
        }

        return $tabs;
    }
}
