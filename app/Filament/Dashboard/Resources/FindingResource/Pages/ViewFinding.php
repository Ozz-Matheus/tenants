<?php

namespace App\Filament\Dashboard\Resources\FindingResource\Pages;

use App\Filament\Dashboard\Resources\FindingResource;
use App\Filament\Dashboard\Resources\ProcessAuditResource;
use App\Traits\HasControlContext;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewFinding extends ViewRecord
{
    use HasControlContext;

    protected static string $resource = FindingResource::class;

    public function mount(string|int $record): void
    {
        parent::mount($record);
        $this->loadControlContext();
    }

    protected function getHeaderActions(): array
    {
        return [

            Action::make('back')
                ->label(__('Return'))
                ->url(fn (): string => ProcessAuditResource::getUrl('audit_control.view', ['audit' => $this->controlModel->audit_id, 'record' => $this->control_id]))
                ->button()
                ->color('gray'),
        ];
    }
}
