<?php

namespace App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Pages;

use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\LegalRequirementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLegalRequirements extends ListRecords
{
    protected static string $resource = LegalRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
