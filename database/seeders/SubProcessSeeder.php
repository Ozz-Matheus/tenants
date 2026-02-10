<?php

namespace Database\Seeders;

use App\Models\Subprocess;
use Illuminate\Database\Seeder;

class SubprocessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subprocesses = [
            // Cadena de suministros (process_id: 1)
            ['title' => 'Comercio exterior', 'acronym' => 'CE', 'process_id' => 1],
            ['title' => 'Servicio al cliente', 'acronym' => 'SAC', 'process_id' => 1],
            // Calidad (process_id: 2)
            ['title' => 'Aprobación de producto terminado', 'acronym' => 'APT', 'process_id' => 2],
            ['title' => 'Producto no conforme', 'acronym' => 'PNC', 'process_id' => 2],
            // Gestión financiera (process_id: 3)
            ['title' => 'Contabilidad', 'acronym' => 'CT', 'process_id' => 3],
            ['title' => 'Tesorería', 'acronym' => 'TR', 'process_id' => 3],
            // Gestión humana (process_id: 4)
            ['title' => 'Gestión de desempeño', 'acronym' => 'GD', 'process_id' => 4],
            ['title' => 'Servicios generales', 'acronym' => 'SG', 'process_id' => 4],
            // Investigación y desarrollo (process_id: 5)
            ['title' => 'Diseño de productos', 'acronym' => 'DP', 'process_id' => 5],
            ['title' => 'Mantenimiento de portafolio', 'acronym' => 'MP', 'process_id' => 5],
        ];

        foreach ($subprocesses as $subprocess) {
            Subprocess::firstOrCreate($subprocess);
        }
    }
}
