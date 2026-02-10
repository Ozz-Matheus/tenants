<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            HeadquarterSeeder::class,
            RolesSeeder::class,
            ProcessSeeder::class,
            SubProcessSeeder::class,
            UserHasSubProcessesSeeder::class,
            UsersLeadSubProcessesSeeder::class,
            // Documentos
            DocTypeSeeder::class,
            DocStorageSeeder::class,
            DocRecoverySeeder::class,
            DocDispositionSeeder::class,
        ]);
    }
}
