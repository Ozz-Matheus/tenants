<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['name' => 'super_admin']);
        // $managerRole = Role::create(['name' => 'panel_user']);

        $superAdmin = new User;
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 's@t.co';
        $superAdmin->password = bcrypt('s@t.co');
        $superAdmin->save();

        $superAdmin->assignRole($superAdminRole);

        // $manager = new User;
        // $manager->name = 'Manager';
        // $manager->email = 'm@t.co';
        // $manager->password = bcrypt('u@t.co');
        // $manager->save();

        // $manager->assignRole($managerRole);
    }
}
