<?php

namespace App\Traits;

use App\Filament\Dashboard\Resources\CorrectiveResource;
use App\Filament\Dashboard\Resources\ImproveResource;
use App\Filament\Dashboard\Resources\PreventiveResource;

trait HasFilamentResource
{
    public function getResourceClass(): ?string
    {
        return match ($this->type?->name) {
            'improve' => ImproveResource::class,
            'corrective' => CorrectiveResource::class,
            'preventive' => PreventiveResource::class,
            default => null,
        };
    }

    public function getFilamentUrl(string $page = 'view'): ?string
    {
        $resource = $this->getResourceClass();

        return $resource ? $resource::getUrl($page, ['record' => $this]) : null;
    }
}
