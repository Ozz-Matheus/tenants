<?php

namespace App\Filament\Dashboard\Resources\FindingResource\Pages;

use App\Filament\Dashboard\Resources\FindingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinding extends EditRecord
{
    protected static string $resource = FindingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
