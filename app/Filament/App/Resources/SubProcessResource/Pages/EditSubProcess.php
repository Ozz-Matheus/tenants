<?php

namespace App\Filament\App\Resources\SubProcessResource\Pages;

use App\Filament\App\Resources\SubProcessResource;
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
