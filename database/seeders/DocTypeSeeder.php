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
            ['name' => 'document', 'label' => 'Documento', 'acronym' => 'D'],
            ['name' => 'instructive', 'label' => 'Instructivo', 'acronym' => 'I'],
            ['name' => 'policy', 'label' => 'Política', 'acronym' => 'P'],
            ['name' => 'matrix', 'label' => 'Matriz', 'acronym' => 'M'],
            ['name' => 'format', 'label' => 'Formato', 'acronym' => 'F'],
        ];

        foreach ($docTypes as $docType) {
            DocType::create($docType);
        }
    }
}
