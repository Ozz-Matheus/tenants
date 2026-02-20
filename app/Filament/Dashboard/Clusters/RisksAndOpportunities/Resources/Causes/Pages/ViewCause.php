<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\CauseResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewCause extends ViewRecord
{
    protected static string $resource = CauseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('back')
                ->label(__('Back'))
                ->url(fn () => CauseResource::getUrl('index'))
                ->color('gray')
                ->icon(Heroicon::ArrowLeft),
        ];
    }
}
