<?php

namespace App\Filament\Dashboard\Resources\ActionTypeResource\Pages;

use App\Filament\Dashboard\Resources\ActionTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActionType extends EditRecord
{
    protected static string $resource = ActionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
