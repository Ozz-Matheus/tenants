<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Pages;

use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\SubprocessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListSubprocesses extends ListRecords
{
    protected static string $resource = SubprocessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->icon(Heroicon::PlusCircle),
        ];
    }
}
