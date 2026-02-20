<?php

namespace Database\Seeders;

use App\Enums\StorageMethodEnum;
use App\Models\DocRecovery;
use Illuminate\Database\Seeder;

class DocRecoverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docRecoveries = [
            ['storage_method' => StorageMethodEnum::PHYSYCAL, 'title' => 'Incice manual'],
            ['storage_method' => StorageMethodEnum::DIGITAL, 'title' => 'Búsqueda por metadatos'],
        ];

        foreach ($docRecoveries as $docRecovery) {
            DocRecovery::create($docRecovery);
        }
    }
}
