<?php

namespace App\Filament\Dashboard\Resources\ControlResource\Pages;

use App\Filament\Dashboard\Resources\ControlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControl extends EditRecord
{
    protected static string $resource = ControlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
