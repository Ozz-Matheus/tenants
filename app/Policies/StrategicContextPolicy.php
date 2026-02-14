<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\StrategicContext;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class StrategicContextPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StrategicContext');
    }

    public function view(AuthUser $authUser, StrategicContext $strategicContext): bool
    {
        return $authUser->can('View:StrategicContext');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StrategicContext');
    }

    public function update(AuthUser $authUser, StrategicContext $strategicContext): bool
    {
        return $authUser->can('Update:StrategicContext');
    }

    public function delete(AuthUser $authUser, StrategicContext $strategicContext): bool
    {
        return $authUser->can('Delete:StrategicContext');
    }

    public function restore(AuthUser $authUser, StrategicContext $strategicContext): bool
    {
        return $authUser->can('Restore:StrategicContext');
    }

    public function forceDelete(AuthUser $authUser, StrategicContext $strategicContext): bool
    {
        return $authUser->can('ForceDelete:StrategicContext');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StrategicContext');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StrategicContext');
    }

    public function replicate(AuthUser $authUser, StrategicContext $strategicContext): bool
    {
        return $authUser->can('Replicate:StrategicContext');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StrategicContext');
    }
}
