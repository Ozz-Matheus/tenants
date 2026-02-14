<?php

namespace App\Filament\Dashboard\Resources\Headquarters\Pages;

use App\Filament\Dashboard\Resources\Headquarters\HeadquarterResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHeadquarter extends CreateRecord
{
    protected static string $resource = HeadquarterResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
