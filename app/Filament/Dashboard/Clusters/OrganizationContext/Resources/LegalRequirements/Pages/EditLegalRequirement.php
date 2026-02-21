<?php

namespace App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Pages;

use App\Enums\RoleEnum;
use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\LegalRequirementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLegalRequirement extends EditRecord
{
    protected static string $resource = LegalRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(function () {
                    return ! auth()->user()->hasRole(RoleEnum::SUPER_ADMIN);
                }),

        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
