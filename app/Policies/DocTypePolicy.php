<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DocType;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class DocTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DocType');
    }

    public function view(AuthUser $authUser, DocType $docType): bool
    {
        return $authUser->can('View:DocType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DocType');
    }

    public function update(AuthUser $authUser, DocType $docType): bool
    {
        return $authUser->can('Update:DocType');
    }

    public function delete(AuthUser $authUser, DocType $docType): bool
    {
        return $authUser->can('Delete:DocType');
    }

    public function restore(AuthUser $authUser, DocType $docType): bool
    {
        return $authUser->can('Restore:DocType');
    }

    public function forceDelete(AuthUser $authUser, DocType $docType): bool
    {
        return $authUser->can('ForceDelete:DocType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DocType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DocType');
    }

    public function replicate(AuthUser $authUser, DocType $docType): bool
    {
        return $authUser->can('Replicate:DocType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DocType');
    }
}
