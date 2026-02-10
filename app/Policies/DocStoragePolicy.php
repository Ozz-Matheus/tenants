<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DocStorage;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class DocStoragePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:DocStorage');
    }

    public function view(AuthUser $authUser, DocStorage $docStorage): bool
    {
        return $authUser->can('View:DocStorage');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:DocStorage');
    }

    public function update(AuthUser $authUser, DocStorage $docStorage): bool
    {
        return $authUser->can('Update:DocStorage');
    }

    public function delete(AuthUser $authUser, DocStorage $docStorage): bool
    {
        return $authUser->can('Delete:DocStorage');
    }

    public function restore(AuthUser $authUser, DocStorage $docStorage): bool
    {
        return $authUser->can('Restore:DocStorage');
    }

    public function forceDelete(AuthUser $authUser, DocStorage $docStorage): bool
    {
        return $authUser->can('ForceDelete:DocStorage');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:DocStorage');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:DocStorage');
    }

    public function replicate(AuthUser $authUser, DocStorage $docStorage): bool
    {
        return $authUser->can('Replicate:DocStorage');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:DocStorage');
    }
}
