<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $rolePanelUser = Role::findByName('panel_user');

        // Permisos

        $permissionViewAnyProcess = Permission::findByName('view_any_process');
        $permissionViewProcess = Permission::findByName('view_process');
        $permissionCreateProcess = Permission::findByName('create_process');
        $permissionUpdateProcess = Permission::findByName('update_process');
        // $permissionDeleteProcess = Permission::findByName('delete_process');

        // Permisos Panel User

        $rolePanelUser->givePermissionTo($permissionViewAnyProcess);
        $rolePanelUser->givePermissionTo($permissionViewProcess);
        $rolePanelUser->givePermissionTo($permissionCreateProcess);
        $rolePanelUser->givePermissionTo($permissionUpdateProcess);
        // $rolePanelUser->givePermissionTo($permissionDeleteProcess);

    }
}
