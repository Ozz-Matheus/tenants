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
            // Contexto estrategico
            StrategicContextSeeder::class,
            // Documentos
            DocTypeSeeder::class,
            DocRecoverySeeder::class,
            DocDispositionSeeder::class,
            // Riesgos
            ItemValueSeeder::class,
        ]);
    }
}
