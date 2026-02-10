<?php

namespace App\Filament\Dashboard\Resources\Docs\Pages;

use App\Enums\RoleEnum;
use App\Filament\Dashboard\Resources\Docs\DocResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDoc extends EditRecord
{
    protected static string $resource = DocResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            RestoreAction::make(),
            ForceDeleteAction::make()
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
