<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\RiskResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewRisk extends ViewRecord
{
    protected static string $resource = RiskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('back')
                ->label(__('Back'))
                ->url(fn () => RiskResource::getUrl('index'))
                ->color('gray')
                ->icon(Heroicon::ArrowLeft),
        ];
    }
}
