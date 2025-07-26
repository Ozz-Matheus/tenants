<?php

namespace App\Filament\Dashboard\Resources\DocResource\Pages;

use App\Filament\Dashboard\Resources\DocResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDoc extends EditRecord
{
    protected static string $resource = DocResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
