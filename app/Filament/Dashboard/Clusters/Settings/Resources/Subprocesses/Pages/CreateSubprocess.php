<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\SubprocessResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubprocess extends CreateRecord
{
    protected static string $resource = SubprocessResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
