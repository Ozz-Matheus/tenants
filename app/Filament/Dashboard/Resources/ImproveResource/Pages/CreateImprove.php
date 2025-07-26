<?php

namespace App\Filament\Dashboard\Resources\ImproveResource\Pages;

use App\Filament\Dashboard\Resources\ImproveResource;
use App\Traits\HandlesActionCreation;
use Filament\Resources\Pages\CreateRecord;

class CreateImprove extends CreateRecord
{
    use HandlesActionCreation;

    protected static string $resource = ImproveResource::class;
}
