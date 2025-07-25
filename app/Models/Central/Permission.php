<?php

namespace App\Models\Central;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $connection = 'central'; // usa la base de datos central
}
