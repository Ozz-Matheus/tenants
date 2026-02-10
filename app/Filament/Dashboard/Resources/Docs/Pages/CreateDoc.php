<?php

namespace App\Filament\Dashboard\Resources\Docs\Pages;

use App\Filament\Dashboard\Resources\Docs\DocResource;
use App\Notifications\DocCreatedNotice;
use App\Services\DocService;
use App\Support\AppNotifier;
use Filament\Resources\Pages\CreateRecord;

class CreateDoc extends CreateRecord
{
    protected static string $resource = DocResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        if (! $user->canAccessSubProcess($data['subprocess_id'] ?? null)) {

            AppNotifier::danger(
                __('Access denied'),
                __('You do not have permission to create this file.'),
                true
            );

            $this->halt();
        }

        $data['classification_code'] = app(DocService::class)->generateCode($data['doc_type_id'], $data['subprocess_id'], $data['headquarter_id'] ?? null);
        $data['created_by_id'] = $user->id;

        return $data;
    }

    protected function afterCreate(): void
    {

        auth()->user()->notify(new DocCreatedNotice($this->record));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
