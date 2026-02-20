<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\EffectivenessLevelRange;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class EffectivenessLevelRangePolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EffectivenessLevelRange');
    }

    public function view(AuthUser $authUser, EffectivenessLevelRange $effectivenessLevelRange): bool
    {
        return $authUser->can('View:EffectivenessLevelRange');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EffectivenessLevelRange');
    }

    public function update(AuthUser $authUser, EffectivenessLevelRange $effectivenessLevelRange): bool
    {
        return $authUser->can('Update:EffectivenessLevelRange');
    }

    public function delete(AuthUser $authUser, EffectivenessLevelRange $effectivenessLevelRange): bool
    {
        return $authUser->can('Delete:EffectivenessLevelRange');
    }

    public function restore(AuthUser $authUser, EffectivenessLevelRange $effectivenessLevelRange): bool
    {
        return $authUser->can('Restore:EffectivenessLevelRange');
    }

    public function forceDelete(AuthUser $authUser, EffectivenessLevelRange $effectivenessLevelRange): bool
    {
        return $authUser->can('ForceDelete:EffectivenessLevelRange');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EffectivenessLevelRange');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EffectivenessLevelRange');
    }

    public function replicate(AuthUser $authUser, EffectivenessLevelRange $effectivenessLevelRange): bool
    {
        return $authUser->can('Replicate:EffectivenessLevelRange');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EffectivenessLevelRange');
    }
}
