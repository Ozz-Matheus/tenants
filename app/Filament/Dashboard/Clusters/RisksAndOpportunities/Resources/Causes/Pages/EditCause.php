<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\CauseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCause extends EditRecord
{
    protected static string $resource = CauseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
