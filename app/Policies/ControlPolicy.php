<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Control;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ControlPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Control');
    }

    public function view(AuthUser $authUser, Control $control): bool
    {
        return $authUser->can('View:Control');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Control');
    }

    public function update(AuthUser $authUser, Control $control): bool
    {
        return $authUser->can('Update:Control');
    }

    public function delete(AuthUser $authUser, Control $control): bool
    {
        return $authUser->can('Delete:Control');
    }

    public function restore(AuthUser $authUser, Control $control): bool
    {
        return $authUser->can('Restore:Control');
    }

    public function forceDelete(AuthUser $authUser, Control $control): bool
    {
        return $authUser->can('ForceDelete:Control');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Control');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Control');
    }

    public function replicate(AuthUser $authUser, Control $control): bool
    {
        return $authUser->can('Replicate:Control');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Control');
    }
}
