<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\LegalRequirement;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class LegalRequirementPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LegalRequirement');
    }

    public function view(AuthUser $authUser, LegalRequirement $legalRequirement): bool
    {
        return $authUser->can('View:LegalRequirement');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LegalRequirement');
    }

    public function update(AuthUser $authUser, LegalRequirement $legalRequirement): bool
    {
        return $authUser->can('Update:LegalRequirement');
    }

    public function delete(AuthUser $authUser, LegalRequirement $legalRequirement): bool
    {
        return $authUser->can('Delete:LegalRequirement');
    }

    public function restore(AuthUser $authUser, LegalRequirement $legalRequirement): bool
    {
        return $authUser->can('Restore:LegalRequirement');
    }

    public function forceDelete(AuthUser $authUser, LegalRequirement $legalRequirement): bool
    {
        return $authUser->can('ForceDelete:LegalRequirement');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LegalRequirement');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LegalRequirement');
    }

    public function replicate(AuthUser $authUser, LegalRequirement $legalRequirement): bool
    {
        return $authUser->can('Replicate:LegalRequirement');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LegalRequirement');
    }
}
