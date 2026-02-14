<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\DocRecoveryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDocRecovery extends EditRecord
{
    protected static string $resource = DocRecoveryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
