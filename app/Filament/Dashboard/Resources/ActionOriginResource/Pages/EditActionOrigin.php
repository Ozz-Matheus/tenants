<?php

namespace App\Filament\Dashboard\Resources\ActionOriginResource\Pages;

use App\Filament\Dashboard\Resources\ActionOriginResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActionOrigin extends EditRecord
{
    protected static string $resource = ActionOriginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
