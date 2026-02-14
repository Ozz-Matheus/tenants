<?php

namespace App\Filament\Dashboard\Resources\Headquarters\Pages;

use App\Filament\Dashboard\Resources\Headquarters\HeadquarterResource;
use App\Support\AppNotifier;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHeadquarter extends EditRecord
{
    protected static string $resource = HeadquarterResource::class;

    protected function getHeaderActions(): array
    {
        return [

            // Acción informativa cuando NO se puede borrar
            Action::make('cannotDeleteInfo')
                ->label(__('headquarter.model_label'))
                ->icon('heroicon-o-lock-closed')
                ->color('gray')
                ->visible(fn ($record) => $record->users()->exists())
                ->tooltip(__('headquarter.reassign_before_delete'))
                ->action(function () {

                    AppNotifier::warning(
                        __('headquarter.model_label'),
                        __('headquarter.reassign_before_delete')
                    );

                    $this->halt();
                }),

            // Acción real de borrado, solo visible cuando sí se puede
            DeleteAction::make()
                ->visible(fn ($record) => ! $record->users()->exists()),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
