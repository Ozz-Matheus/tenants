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
            DocTypeSeeder::class,
            DocExpirationSeeder::class,
            DocEndingSeeder::class,
            StatusSeeder::class,
            ActionOriginSeeder::class,
            ActionTypeSeeder::class,
            ActionAnalysisCauseSeeder::class,
            ActionVerificationMethodSeeder::class,
            AuditCriteriaSeeder::class,
            ProcessRiskSeeder::class,
            ControlTypeSeeder::class,
        ]);
    }
}
