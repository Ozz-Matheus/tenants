<?php

namespace App\Filament\Dashboard\Resources\ProcessAuditResource\Pages;

use App\Filament\Dashboard\Resources\ProcessAuditResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewAudit extends ViewRecord
{
    protected static string $resource = ProcessAuditResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Return'))
                ->url(fn (): string => ProcessAuditResource::getUrl('index'))
                ->button()
                ->color('gray'),
        ];
    }
}
