<?php

namespace App\Filament\Dashboard\Resources\DocVersionResource\Pages;

use App\Filament\Dashboard\Resources\DocResource;
use App\Filament\Dashboard\Resources\DocVersionResource;
use App\Traits\HasDocContext;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListDocVersions extends ListRecords
{
    use HasDocContext;

    protected static string $resource = DocVersionResource::class;

    public function mount(): void
    {
        parent::mount();
        $this->loadDocContext();
        $this->checkVersionStatusNotice();
    }

    public function getTableQuery(): ?Builder
    {
        $query = parent::getTableQuery();

        if ($this->doc_id) {
            $query->where('doc_id', $this->doc_id);

            if (! $this->tableSortColumn) {
                $query->orderByDesc('version');
            }
        }

        return $query;
    }

    protected function getHeaderActions(): array
    {
        if (! $this->doc_id) {
            return [];
        }

        return [

            Action::make('context')
                ->label($this->docModel?->getContextPath())
                ->icon('heroicon-o-information-circle')
                ->disabled()
                ->color('gray'),

            Action::make('addFile')
                ->label(__('Upload file'))
                ->button()
                ->authorize(fn ($record) => auth()->user()->can('create_doc::version', $record))
                ->url(fn (): string => DocResource::getUrl('versions.create', [
                    'doc' => $this->doc_id,
                ])),
            Action::make('back')
                ->label(__('Return'))
                ->url(fn (): string => DocResource::getUrl('index'))
                ->button()
                ->color('gray'),

        ];
    }

    public function getSubheading(): ?string
    {
        return $this->docModel?->title;
    }

    public function getBreadcrumbs(): array
    {
        return [
            DocResource::getUrl('index') => __('Documents'),
            DocResource::getUrl('versions.index', ['doc' => $this->doc_id]) => __('Versions'),
            false => __('List'),
        ];
    }
}
