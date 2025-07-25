<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $panelRole = Role::firstOrCreate(['name' => 'panel_user']);

        // Crear permisos base
        $permissions = [
            'view_role',
            'view_any_role',
            'create_role',
            'update_role',
        ];

        // Crear y asegurar permisos
        $permissionModels = collect($permissions)->map(function ($name) {
            return Permission::firstOrCreate(['name' => $name]);
        });

        // Asignar permisos reales al rol admin
        $superAdminRole->syncPermissions($permissionModels->pluck('name')->toArray());

        // Asignar permisos limitados al rol panel
        // $panelPermissions = [
        //     'view_any_process',
        //     'view_process',
        //     'create_process',
        //     'update_process',
        //     'delete_process',
        //     'view_any_sub::process',
        //     'view_sub::process',
        //     'create_sub::process',
        //     'update_sub::process',
        //     'delete_sub::process',
        // ];

        // $panelPermissionModels = collect($panelPermissions)->map(function ($name) {
        //     return Permission::firstOrCreate(['name' => $name]);
        // });

        // $panelRole->syncPermissions($panelPermissionModels->pluck('name')->toArray());

        // Crear usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@company.test'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin@company.test'),
            ]
        );
        $admin->assignRole($superAdminRole);

        // Crear usuario panel
        $panelUser = User::firstOrCreate(
            ['email' => 'panel@company.test'],
            [
                'name' => 'Panel User',
                'password' => bcrypt('panel@company.test'),
            ]
        );
        $panelUser->assignRole($panelRole);
    }
}
