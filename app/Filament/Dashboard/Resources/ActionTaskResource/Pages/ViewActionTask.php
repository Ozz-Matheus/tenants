<?php

namespace App\Filament\Dashboard\Resources\ActionTaskResource\Pages;

use App\Filament\Dashboard\Resources\ActionTaskResource;
use App\Services\TaskService;
use App\Traits\HasActionContext;
use Filament\Actions\Action as FilamentAction;
use Filament\Resources\Pages\ViewRecord;

class ViewActionTask extends ViewRecord
{
    use HasActionContext;

    protected static string $resource = ActionTaskResource::class;

    public function mount(string|int $record): void
    {
        parent::mount($record);
        $this->loadActionContext();
    }

    protected function getHeaderActions(): array
    {

        return [

            FilamentAction::make('finish_task')
                ->label(__('End task'))
                ->button()
                ->color('success')
                ->authorize(fn ($record) => app(TaskService::class)->canCloseTask($record))
                ->action(function ($record) {
                    app(TaskService::class)->closeTask($record);
                    redirect($record->action->getFilamentUrl());
                }),

            FilamentAction::make('back')
                ->label(__('Return'))
                ->url(fn ($record): string => $record->action->getFilamentUrl())
                ->button()
                ->color('gray'),

        ];
    }

    public function getSubheading(): ?string
    {
        return $this->actionModel->title;
    }

    public function getBreadcrumbs(): array
    {
        return [
            $this->actionModel->getFilamentUrl() => ucfirst($this->actionModel->type->name),
            false => 'View',
        ];
    }
}
