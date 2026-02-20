<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\ControlResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewControl extends ViewRecord
{
    protected static string $resource = ControlResource::class;

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return SubNavigationPosition::Top;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('back')
                ->label(__('Back'))
                ->url(fn () => ControlResource::getUrl('index'))
                ->color('gray')
                ->icon(Heroicon::ArrowLeft),
        ];
    }
}
