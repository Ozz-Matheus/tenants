<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Pages;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\EvaluationResource;
use App\Services\FileService;
use Filament\Resources\Pages\CreateRecord;

class CreateEvaluation extends CreateRecord
{
    protected static string $resource = EvaluationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $userId = auth()->id();

        $data['created_by_id'] = $userId;
        $data['updated_by_id'] = $userId;

        return $data;
    }

    protected function afterCreate(): void
    {
        app(FileService::class)->createFiles($this->record, $this->form->getState());
    }
}
