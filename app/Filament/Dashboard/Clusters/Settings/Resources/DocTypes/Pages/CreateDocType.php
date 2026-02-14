<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\DocTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocType extends CreateRecord
{
    protected static string $resource = DocTypeResource::class;
}
