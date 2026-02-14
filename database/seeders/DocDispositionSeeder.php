<?php

namespace Database\Seeders;

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
            ['storage_id' => 1, 'title' => 'Destrucción fisica'],
            ['storage_id' => 2, 'title' => 'Borrado digital'],
        ];

        foreach ($docDispositions as $docDisposition) {
            DocDisposition::create($docDisposition);
        }
    }
}
