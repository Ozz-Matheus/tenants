<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\ControlResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\EditRecord;

class EditControl extends EditRecord
{
    protected static string $resource = ControlResource::class;

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return SubNavigationPosition::Top;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
