<?php

namespace Database\Seeders;

use App\Models\DocType;
use Illuminate\Database\Seeder;

class DocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docTypes = [
            ['title' => 'Formato', 'acronym' => 'F'],
            ['title' => 'Documento', 'acronym' => 'D'],
            ['title' => 'Instructivo', 'acronym' => 'I'],
            ['title' => 'Política', 'acronym' => 'P'],
            ['title' => 'Matriz', 'acronym' => 'M'],
        ];

        foreach ($docTypes as $docType) {
            DocType::create($docType);
        }
    }
}
