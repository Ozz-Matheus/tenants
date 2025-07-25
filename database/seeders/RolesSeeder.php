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
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $panelRole = Role::firstOrCreate(['name' => 'panel_user']);

        // Crear permisos base
        $permissions = [
            'view_process',
            'create_process',
            'update_process',
            'delete_process',
            'view_sub::process',
            'create_sub::process',
            'update_sub::process',
            'delete_sub::process',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'view_roles',
            'create_roles',
            'update_roles',
            'delete_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar todos los permisos al rol admin
        $adminRole->syncPermissions($permissions);

        // Asignar permisos limitados al rol panel
        $panelPermissions = [
            'view_process',
            'create_process',
            'view_sub::process',
            'create_sub::process',
        ];
        $panelRole->syncPermissions($panelPermissions);

        // Crear usuario admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@company.test'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin@company.test'),
            ]
        );
        $admin->assignRole($adminRole);

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
