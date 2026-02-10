<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Headquarter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class HeadquarterPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Headquarter');
    }

    public function view(AuthUser $authUser, Headquarter $headquarter): bool
    {
        return $authUser->can('View:Headquarter');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Headquarter');
    }

    public function update(AuthUser $authUser, Headquarter $headquarter): bool
    {
        return $authUser->can('Update:Headquarter');
    }

    public function delete(AuthUser $authUser, Headquarter $headquarter): bool
    {
        return $authUser->can('Delete:Headquarter');
    }

    public function restore(AuthUser $authUser, Headquarter $headquarter): bool
    {
        return $authUser->can('Restore:Headquarter');
    }

    public function forceDelete(AuthUser $authUser, Headquarter $headquarter): bool
    {
        return $authUser->can('ForceDelete:Headquarter');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Headquarter');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Headquarter');
    }

    public function replicate(AuthUser $authUser, Headquarter $headquarter): bool
    {
        return $authUser->can('Replicate:Headquarter');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Headquarter');
    }
}
