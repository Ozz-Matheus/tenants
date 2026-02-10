<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Pages;

use App\Enums\RoleEnum;
use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\SubprocessResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubprocess extends EditRecord
{
    protected static string $resource = SubprocessResource::class;

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
