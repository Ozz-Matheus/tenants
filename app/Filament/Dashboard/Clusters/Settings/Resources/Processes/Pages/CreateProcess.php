<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\ProcessResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProcess extends CreateRecord
{
    protected static string $resource = ProcessResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
