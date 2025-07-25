<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function getConnectionName()
    {
        return tenancy()->initialized ? 'tenant' : config('permission.connection', config('database.default'));
    }
}
