<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\DocVersion;
use App\Notifications\VersionStatusNotice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * Servicio de cambio de estado de versiones
 */
class VersionStatusService
{
    protected VersionService $versionService;

    public function __construct(VersionService $versionService)
    {
        $this->versionService = $versionService;
    }

    // Estados de las versiones.

    public function pending(DocVersion $docVersion): void
    {
        $status = StatusEnum::PENDING;
        $messageBody = $this->getStatusMessage($status, $docVersion);

        $this->updateVersionStatus($docVersion, $status, $messageBody);
    }

    public function rejected(DocVersion $docVersion): void
    {
        $status = StatusEnum::REJECTED;
        $messageBody = $this->getStatusMessage($status, $docVersion);

        $this->updateVersionStatus($docVersion, $status, $messageBody);
    }

    public function approved(DocVersion $docVersion): void
    {

        $status = StatusEnum::APPROVED;

        $messageBody = $this->getStatusMessage($status, $docVersion);

        $data = [
            'status' => $status,
            'doc_id' => $docVersion->doc_id,
            'created_by_id' => $docVersion->created_by_id,
        ];

        $validated = $this->versionService->validatedData($data, ['status', 'created_by_id']);

        DB::transaction(fn () => $docVersion->update($validated));

        $this->notifyStatusChange($docVersion, $status, $messageBody);
    }

    /*
    |--------------------------------------------------------------------------
    | Métodos auxiliares privados.
    |--------------------------------------------------------------------------
    */

    private function getStatusMessage(?StatusEnum $status, $docVersion): string
    {
        return __(
            'emails.document_status_change.important_info_body',
            ['status' => $status->getLabel(), 'version' => $docVersion->version]
        );
    }

    private function updateVersionStatus(DocVersion $docVersion, ?StatusEnum $status, ?string $messageBody = null): void
    {

        $docVersion->update([
            'status' => $status,
        ]);

        $this->notifyStatusChange($docVersion, $status, $messageBody ?? '');
    }

    protected function notifyStatusChange(DocVersion $docVersion, ?StatusEnum $status, string $messageBody): void
    {
        $user = auth()->user();

        $leaders = $user->getLeadersToSubProcess($docVersion->doc->subprocess_id);

        $notifiables = collect([$user, $docVersion->createdBy])->merge($leaders ?? [])
            ->filter()
            ->unique('id');

        Notification::send($notifiables, new VersionStatusNotice($docVersion, $status, $messageBody));
    }
}
