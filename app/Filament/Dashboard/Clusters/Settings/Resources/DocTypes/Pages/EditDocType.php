<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\DocTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDocType extends EditRecord
{
    protected static string $resource = DocTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->disabled(fn () => $this->record->id === 1),
        ];
    }
}
