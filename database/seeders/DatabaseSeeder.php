<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            ProcessSeeder::class,
            SubProcessSeeder::class,
            UserHasSubProcessesSeeder::class,
        ]);
    }
}
