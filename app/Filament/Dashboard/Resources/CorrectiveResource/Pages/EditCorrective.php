<?php

namespace App\Filament\Dashboard\Resources\CorrectiveResource\Pages;

use App\Filament\Dashboard\Resources\CorrectiveResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorrective extends EditRecord
{
    protected static string $resource = CorrectiveResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
