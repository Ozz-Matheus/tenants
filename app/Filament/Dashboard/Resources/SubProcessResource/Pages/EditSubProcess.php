<?php

namespace App\Filament\Dashboard\Resources\SubProcessResource\Pages;

use App\Filament\Dashboard\Resources\SubProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubProcess extends EditRecord
{
    protected static string $resource = SubProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
