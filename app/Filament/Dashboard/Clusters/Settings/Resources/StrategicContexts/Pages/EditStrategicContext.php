<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\StrategicContextResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStrategicContext extends EditRecord
{
    protected static string $resource = StrategicContextResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
