<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Cause;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class CausePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Cause');
    }

    public function view(AuthUser $authUser, Cause $cause): bool
    {
        return $authUser->can('View:Cause');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Cause');
    }

    public function update(AuthUser $authUser, Cause $cause): bool
    {
        return $authUser->can('Update:Cause');
    }

    public function delete(AuthUser $authUser, Cause $cause): bool
    {
        return $authUser->can('Delete:Cause');
    }

    public function restore(AuthUser $authUser, Cause $cause): bool
    {
        return $authUser->can('Restore:Cause');
    }

    public function forceDelete(AuthUser $authUser, Cause $cause): bool
    {
        return $authUser->can('ForceDelete:Cause');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Cause');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Cause');
    }

    public function replicate(AuthUser $authUser, Cause $cause): bool
    {
        return $authUser->can('Replicate:Cause');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Cause');
    }
}
