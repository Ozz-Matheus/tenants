<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DocRecovery;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class DocRecoveryPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DocRecovery');
    }

    public function view(AuthUser $authUser, DocRecovery $docRecovery): bool
    {
        return $authUser->can('View:DocRecovery');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DocRecovery');
    }

    public function update(AuthUser $authUser, DocRecovery $docRecovery): bool
    {
        return $authUser->can('Update:DocRecovery');
    }

    public function delete(AuthUser $authUser, DocRecovery $docRecovery): bool
    {
        return $authUser->can('Delete:DocRecovery');
    }

    public function restore(AuthUser $authUser, DocRecovery $docRecovery): bool
    {
        return $authUser->can('Restore:DocRecovery');
    }

    public function forceDelete(AuthUser $authUser, DocRecovery $docRecovery): bool
    {
        return $authUser->can('ForceDelete:DocRecovery');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DocRecovery');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DocRecovery');
    }

    public function replicate(AuthUser $authUser, DocRecovery $docRecovery): bool
    {
        return $authUser->can('Replicate:DocRecovery');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DocRecovery');
    }
}
