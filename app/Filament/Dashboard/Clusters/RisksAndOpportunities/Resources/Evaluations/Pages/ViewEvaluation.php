<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\EvaluationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewEvaluation extends ViewRecord
{
    protected static string $resource = EvaluationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Back'))
                ->url(fn () => EvaluationResource::getUrl('index'))
                ->color('gray')
                ->icon(Heroicon::ArrowLeft),
        ];
    }
}
