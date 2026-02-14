<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\DocDispositionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocDispositions extends ListRecords
{
    protected static string $resource = DocDispositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
