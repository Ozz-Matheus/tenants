<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Pages;

use App\Enums\RoleEnum;
use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\ProcessResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProcess extends EditRecord
{
    protected static string $resource = ProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(function () {
                    return auth()->user()->hasRole(RoleEnum::SUPER_ADMIN);
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
