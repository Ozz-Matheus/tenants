<?php

namespace App\Filament\Dashboard\Resources\CorrectiveResource\Pages;

use App\Filament\Dashboard\Resources\CorrectiveResource;
use App\Traits\HandlesActionCreation;
use Filament\Resources\Pages\CreateRecord;

class CreateCorrective extends CreateRecord
{
    use HandlesActionCreation;

    protected static string $resource = CorrectiveResource::class;
}
