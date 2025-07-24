<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $basicRole = Role::create(['name' => 'panel_user']);

        $superAdmin = new User;
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 's@t.co';
        $superAdmin->password = bcrypt('s@t.co');
        $superAdmin->save();

        $superAdmin->assignRole($superAdminRole);

        $basic = new User;
        $basic->name = 'User';
        $basic->email = 'u@t.co';
        $basic->password = bcrypt('u@t.co');
        $basic->save();

        $basic->assignRole($basicRole);
    }
}
