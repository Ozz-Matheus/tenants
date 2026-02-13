<?php

namespace App\Filament\Admin\Resources\Tenants\Pages;

use App\Filament\Admin\Resources\Tenants\TenantResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTenant extends ViewRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('open')
                ->label(trans('tenant.actions.view'))
                ->icon('heroicon-s-link')
                ->url(fn ($record) => $record->admin_url)
                ->openUrlInNewTab(),

            EditAction::make(),
        ];
    }
}
