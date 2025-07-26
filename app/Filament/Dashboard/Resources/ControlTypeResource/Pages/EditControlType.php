<?php

namespace App\Filament\Dashboard\Resources\ControlTypeResource\Pages;

use App\Filament\Dashboard\Resources\ControlTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControlType extends EditRecord
{
    protected static string $resource = ControlTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
