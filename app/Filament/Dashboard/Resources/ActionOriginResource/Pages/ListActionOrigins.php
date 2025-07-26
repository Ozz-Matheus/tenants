<?php

namespace App\Filament\Dashboard\Resources\ActionOriginResource\Pages;

use App\Filament\Dashboard\Resources\ActionOriginResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActionOrigins extends ListRecords
{
    protected static string $resource = ActionOriginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
