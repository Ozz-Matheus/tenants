<?php

namespace Database\Seeders;

use App\Models\StrategicContext;
use Illuminate\Database\Seeder;

class StrategicContextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strategicContexts = [
            // Interno
            ['type' => 1, 'title' => 'Estructura'],
            ['type' => 1, 'title' => 'Recursos'],
            ['type' => 1, 'title' => 'Cultura'],
            ['type' => 1, 'title' => 'Estrategia'],
            // Externo
            ['type' => 2, 'title' => 'Político'],
            ['type' => 2, 'title' => 'Económico'],
            ['type' => 2, 'title' => 'Social'],
            ['type' => 2, 'title' => 'Tecnológico'],
            ['type' => 2, 'title' => 'Ecológico/Ambiental'],
            ['type' => 2, 'title' => 'Legal'],
        ];

        foreach ($strategicContexts as $strategicContext) {
            StrategicContext::create($strategicContext);
        }
    }
}
