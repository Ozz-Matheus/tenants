<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\DocDispositionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDocDisposition extends EditRecord
{
    protected static string $resource = DocDispositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
