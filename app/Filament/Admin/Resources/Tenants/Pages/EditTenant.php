<?php

namespace App\Filament\Admin\Resources\Tenants\Pages;

use App\Filament\Admin\Resources\Tenants\TenantResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('open')
                ->label(trans('filament-tenancy::messages.actions.view'))
                ->icon('heroicon-s-link')
                ->url(fn ($record) => $record->admin_url)
                ->openUrlInNewTab(),

            DeleteAction::make()
                ->icon('heroicon-s-trash')
                ->label(trans('filament-tenancy::messages.actions.delete')),
        ];
    }
}
