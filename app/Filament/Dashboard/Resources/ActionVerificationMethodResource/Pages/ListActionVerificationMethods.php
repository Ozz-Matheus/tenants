<?php

namespace App\Filament\Dashboard\Resources\ActionVerificationMethodResource\Pages;

use App\Filament\Dashboard\Resources\ActionVerificationMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActionVerificationMethods extends ListRecords
{
    protected static string $resource = ActionVerificationMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
