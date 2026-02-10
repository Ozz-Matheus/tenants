<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DocDisposition;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class DocDispositionPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DocDisposition');
    }

    public function view(AuthUser $authUser, DocDisposition $docDisposition): bool
    {
        return $authUser->can('View:DocDisposition');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DocDisposition');
    }

    public function update(AuthUser $authUser, DocDisposition $docDisposition): bool
    {
        return $authUser->can('Update:DocDisposition');
    }

    public function delete(AuthUser $authUser, DocDisposition $docDisposition): bool
    {
        return $authUser->can('Delete:DocDisposition');
    }

    public function restore(AuthUser $authUser, DocDisposition $docDisposition): bool
    {
        return $authUser->can('Restore:DocDisposition');
    }

    public function forceDelete(AuthUser $authUser, DocDisposition $docDisposition): bool
    {
        return $authUser->can('ForceDelete:DocDisposition');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DocDisposition');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DocDisposition');
    }

    public function replicate(AuthUser $authUser, DocDisposition $docDisposition): bool
    {
        return $authUser->can('Replicate:DocDisposition');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DocDisposition');
    }
}
