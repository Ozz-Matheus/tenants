<?php

namespace App\Filament\Dashboard\Resources\DocExpirationResource\Pages;

use App\Filament\Dashboard\Resources\DocExpirationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocExpiration extends EditRecord
{
    protected static string $resource = DocExpirationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
