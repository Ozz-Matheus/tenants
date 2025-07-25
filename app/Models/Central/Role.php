<?php

namespace App\Models\Central;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $connection = 'central'; // o 'mysql'
}
