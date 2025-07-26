<?php

namespace App\Filament\Dashboard\Resources\ActionEndingResource\Pages;

use App\Filament\Dashboard\Resources\ActionEndingResource;
use App\Traits\HasActionContext;
use Filament\Actions\Action as FilamentAction;
use Filament\Resources\Pages\ViewRecord;

class ViewActionEnding extends ViewRecord
{
    use HasActionContext;

    protected static string $resource = ActionEndingResource::class;

    public function mount(string|int $record): void
    {
        parent::mount($record);
        $this->loadActionContext();
    }

    protected function getHeaderActions(): array
    {

        return [

            FilamentAction::make('back')
                ->label('Return')
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
