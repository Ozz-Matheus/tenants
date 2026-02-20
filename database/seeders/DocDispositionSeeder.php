<?php

namespace Database\Seeders;

use App\Enums\StorageMethodEnum;
use App\Models\DocDisposition;
use Illuminate\Database\Seeder;

class DocDispositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docDispositions = [
            ['storage_method' => StorageMethodEnum::PHYSYCAL, 'title' => 'Destrucción fisica'],
            ['storage_method' => StorageMethodEnum::DIGITAL, 'title' => 'Borrado digital'],
        ];

        foreach ($docDispositions as $docDisposition) {
            DocDisposition::create($docDisposition);
        }
    }
}
