<?php

namespace App\Filament\Dashboard\Resources\DocTypeResource\Pages;

use App\Filament\Dashboard\Resources\DocTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocType extends CreateRecord
{
    protected static string $resource = DocTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public static function canCreateAnother(): bool
    {
        return false;
    }
}
