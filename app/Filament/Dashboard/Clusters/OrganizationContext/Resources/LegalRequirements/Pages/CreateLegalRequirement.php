<?php

namespace App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Pages;

use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\LegalRequirementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLegalRequirement extends CreateRecord
{
    protected static string $resource = LegalRequirementResource::class;

    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
