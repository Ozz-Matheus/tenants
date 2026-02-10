<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Subprocess;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class SubprocessPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Subprocess');
    }

    public function view(AuthUser $authUser, Subprocess $subprocess): bool
    {
        return $authUser->can('View:Subprocess');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Subprocess');
    }

    public function update(AuthUser $authUser, Subprocess $subprocess): bool
    {
        return $authUser->can('Update:Subprocess');
    }

    public function delete(AuthUser $authUser, Subprocess $subprocess): bool
    {
        return $authUser->can('Delete:Subprocess');
    }

    public function restore(AuthUser $authUser, Subprocess $subprocess): bool
    {
        return $authUser->can('Restore:Subprocess');
    }

    public function forceDelete(AuthUser $authUser, Subprocess $subprocess): bool
    {
        return $authUser->can('ForceDelete:Subprocess');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Subprocess');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Subprocess');
    }

    public function replicate(AuthUser $authUser, Subprocess $subprocess): bool
    {
        return $authUser->can('Replicate:Subprocess');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Subprocess');
    }
}
