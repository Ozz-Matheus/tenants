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
        $AdminRole = Role::create(['name' => 'super_admin']);
        $userRole = Role::create(['name' => 'panel_user']);

        $Admin = new User;
        $Admin->name = 'Super Admin';
        $Admin->email = 's@tc.co';
        $Admin->password = bcrypt('s@tc.co');
        $Admin->save();

        $Admin->assignRole($AdminRole);

        $user = new User;
        $user->name = 'User';
        $user->email = 'u@tc.co';
        $user->password = bcrypt('u@tc.co');
        $user->save();

        $user->assignRole($userRole);
    }
}
