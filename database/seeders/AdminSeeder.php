<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = config('holdingtec.super_admin.email');
        $password = config('holdingtec.super_admin.password');

        $superAdmin = new User;
        $superAdmin->name = 'HoldingTec Admin';
        $superAdmin->email = $email;
        $superAdmin->password = bcrypt($password);
        $superAdmin->save();

        $superAdmin->assignRole(RoleEnum::SUPER_ADMIN);
    }
}
