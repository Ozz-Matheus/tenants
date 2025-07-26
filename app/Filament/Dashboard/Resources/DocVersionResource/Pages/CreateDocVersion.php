<?php

namespace App\Filament\Dashboard\Resources\DocVersionResource\Pages;

use App\Filament\Dashboard\Resources\DocResource;
use App\Filament\Dashboard\Resources\DocVersionResource;
use App\Models\DocVersion;
use App\Services\VersionService;
use App\Traits\HasDocContext;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateDocVersion extends CreateRecord
{
    use HasDocContext;

    protected static string $resource = DocVersionResource::class;

    public function mount(): void
    {
        parent::mount();
        $this->loadDocContext();
    }

    protected function handleRecordCreation(array $data): DocVersion
    {
        $path = $data['path'];
        $name = $data['name'];

        $sha256 = hash('sha256', Storage::disk('public')->path($path));

        $data['sha256_hash'] = $sha256;

        $data['doc_id'] = $this->doc_id;

        $validated = app(VersionService::class)->validatedData($data);

        $version = DocVersion::create($validated);

        $fileMetadata = [

            'name' => $name,
            'path' => $path,
            'mime_type' => Storage::disk('public')->mimeType($path),
            'size' => Storage::disk('public')->size($path),

        ];

        $version->file()->create($fileMetadata);

        return $version;
    }

    protected function getRedirectUrl(): string
    {
        return DocResource::getUrl('versions.index', ['doc' => $this->doc_id]);
    }

    public static function canCreateAnother(): bool
    {
        return false;
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('context')
                ->label($this->docModel?->getContextPath())
                ->icon('heroicon-o-information-circle')
                ->disabled()
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
            false => __('Create'),
        ];
    }
}
