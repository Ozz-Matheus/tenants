<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\DocRecoveryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocRecoveries extends ListRecords
{
    protected static string $resource = DocRecoveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
