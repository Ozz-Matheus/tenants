<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Doc;
use App\Models\DocVersion;
use App\Support\AppNotifier;
use App\Traits\HasVersioning;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Servicio para las versiones
 */
class VersionService
{
    use HasVersioning;

    public function createVersion(Doc $doc, array $data): DocVersion
    {
        return DB::transaction(function () use ($doc, $data) {
            // 1. Preparar datos del archivo
            $path = $data['path'];
            $disk = config('holdingtec.uploads.disk', 'public');

            // Calculamos hash y metadatos
            $fullPath = Storage::disk($disk)->path($path);

            $sha256 = hash('sha256', Storage::disk($disk)->path($path));

            // 2. Preparar datos de la versión
            $versionData = [
                'doc_id' => $doc->id,
                'sha256_hash' => $sha256,
                'comment' => $data['comment'],
            ];

            // Validamos y calculamos el número de versión
            $validated = $this->validatedData($versionData);

            // 3. Crear registro DocVersion
            $version = DocVersion::create($validated);

            // 4. Crear registro File
            $version->file()->create([
                'name' => $data['original_file_name'] ?? basename($path),
                'path' => $path,
                'mime_type' => Storage::disk($disk)->mimeType($path),
                'size' => Storage::disk($disk)->size($path),
            ]);

            // 5. Asignar Leads (Votantes)
            if (! empty($data['leads'])) {
                $pivotData = [
                    'status' => StatusEnum::PENDING,
                    'comment' => __('Pending version '),
                ];
                $version->leads()->attach($data['leads'], $pivotData);
            }

            return $version;
        });
    }

    public function validatedData(array $data, array $preserve = []): array
    {
        $user = auth()->user();
        $doc = Doc::with('subprocess')->findOrFail($data['doc_id']);

        $hasApprovalAccess = $user->canApproveAndReject($doc->subprocess_id ?? null);

        $statusApproved = StatusEnum::APPROVED;
        $statusDraft = StatusEnum::DRAFT;

        $lastVersion = DocVersion::where('doc_id', $data['doc_id'])
            ->orderByDesc('version')
            ->first();

        $targetStatus = ($data['status'] ?? null) === $statusApproved
            ? StatusEnum::APPROVED
            : null;

        $newVersion = $this->calculateNewVersion($lastVersion?->version, $hasApprovalAccess, $targetStatus);

        return array_merge($data, [
            'version' => $newVersion,
            'status' => in_array('status', $preserve) ? ($data['status'] ?? null) : ($statusDraft),
            'created_by_id' => in_array('created_by_id', $preserve) ? ($data['created_by_id'] ?? null) : $user->id,
        ]);
    }

    public function updateConfidentiality(Doc $record, array $data)
    {
        try {
            $record->update([
                'confidential' => $data['confidential'],
            ]);

            $record->accessToAdditionalUsers()->sync($data['users'] ?? []);

            AppNotifier::success(__('doc.user_update_success'));

        } catch (\Throwable $e) {

            AppNotifier::danger(__('doc.user_update_error'));

            report($e);
        }
    }
}
