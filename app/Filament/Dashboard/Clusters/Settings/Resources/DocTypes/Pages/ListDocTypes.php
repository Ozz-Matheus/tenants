<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\DocTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocTypes extends ListRecords
{
    protected static string $resource = DocTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
