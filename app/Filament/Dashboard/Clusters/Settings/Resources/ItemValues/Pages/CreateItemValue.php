<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\ItemValueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateItemValue extends CreateRecord
{
    protected static string $resource = ItemValueResource::class;
}
