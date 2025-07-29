<?php

namespace App\Filament\Dashboard\Resources\ProcessAuditResource\Pages;

use App\Filament\Dashboard\Resources\ProcessAuditResource;
use App\Models\Status;
use Filament\Resources\Pages\CreateRecord;

class CreateAudit extends CreateRecord
{
    protected static string $resource = ProcessAuditResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status_id'] = Status::byContextAndTitle('audit', 'planned')?->id;

        // dd($data);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public static function canCreateAnother(): bool
    {
        return false;
    }
}
