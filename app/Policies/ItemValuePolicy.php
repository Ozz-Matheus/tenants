<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ItemValue;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class ItemValuePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ItemValue');
    }

    public function view(AuthUser $authUser, ItemValue $itemValue): bool
    {
        return $authUser->can('View:ItemValue');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ItemValue');
    }

    public function update(AuthUser $authUser, ItemValue $itemValue): bool
    {
        return $authUser->can('Update:ItemValue');
    }

    public function delete(AuthUser $authUser, ItemValue $itemValue): bool
    {
        return $authUser->can('Delete:ItemValue');
    }

    public function restore(AuthUser $authUser, ItemValue $itemValue): bool
    {
        return $authUser->can('Restore:ItemValue');
    }

    public function forceDelete(AuthUser $authUser, ItemValue $itemValue): bool
    {
        return $authUser->can('ForceDelete:ItemValue');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:ItemValue');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:ItemValue');
    }

    public function replicate(AuthUser $authUser, ItemValue $itemValue): bool
    {
        return $authUser->can('Replicate:ItemValue');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:ItemValue');
    }
}
