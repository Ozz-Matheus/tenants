<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\ItemValueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditItemValue extends EditRecord
{
    protected static string $resource = ItemValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
