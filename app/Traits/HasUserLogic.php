<?php

namespace App\Traits;

use App\Enums\RoleEnum;
use App\Models\DocVersion;
use App\Models\Subprocess;

trait HasUserLogic
{
    public function getLeadersToSubProcess(?int $subprocessId)
    {
        $subprocess = Subprocess::find($subprocessId);

        // Retorna todos los líderes del subproceso
        return $subprocess?->leaders()->get();
    }

    public function isLeaderOfSubprocess(?int $subprocessId): bool
    {
        return $this->leaderOf()->where('subprocess_id', $subprocessId)->exists();
    }

    public function validSubprocess($subprocessId): bool
    {
        return $this->subprocesses()->where('subprocess_id', $subprocessId)->exists();
    }

    public function canAccessSubprocess(int|string|null $subprocessId): bool
    {
        return $this->hasRole(RoleEnum::SUPER_ADMIN) ||
            ($subprocessId !== null && $this->validSubprocess($subprocessId));
    }

    // Verificación de permisos para el cambiar de estado de una versión del documento.

    public function canPending(DocVersion $docVersion): bool
    {
        return $this->hasRole(RoleEnum::SUPER_ADMIN) || $docVersion->created_by_id === $this->id;
    }

    public function canApproveAndReject(?int $subprocessId): bool
    {
        return $this->hasRole(RoleEnum::SUPER_ADMIN) || $this->isLeaderOfSubprocess($subprocessId);
    }
}
