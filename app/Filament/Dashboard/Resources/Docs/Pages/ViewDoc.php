<?php

namespace App\Filament\Dashboard\Resources\Docs\Pages;

use App\Filament\Dashboard\Resources\Docs\DocResource;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewDoc extends ViewRecord
{
    protected static string $resource = DocResource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Eye;

    public function getSubheading(): ?string
    {
        return $this->record?->title;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Return'))
                ->url(fn (): string => DocResource::getUrl('index'))
                ->icon(Heroicon::ArrowLeft)
                ->color('gray'),
        ];
    }
}
