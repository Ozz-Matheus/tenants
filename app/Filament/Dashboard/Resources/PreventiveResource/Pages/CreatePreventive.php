<?php

namespace App\Filament\Dashboard\Resources\PreventiveResource\Pages;

use App\Filament\Dashboard\Resources\PreventiveResource;
use App\Traits\HandlesActionCreation;
use Filament\Resources\Pages\CreateRecord;

class CreatePreventive extends CreateRecord
{
    use HandlesActionCreation;

    protected static string $resource = PreventiveResource::class;
}
