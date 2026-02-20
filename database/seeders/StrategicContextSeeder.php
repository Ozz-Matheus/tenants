<?php

namespace Database\Seeders;

use App\Enums\StrategicContextTypeEnum;
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
            ['type' => StrategicContextTypeEnum::INTERNAL->value, 'title' => 'Estructura'],
            ['type' => StrategicContextTypeEnum::INTERNAL->value, 'title' => 'Recursos'],
            ['type' => StrategicContextTypeEnum::INTERNAL->value, 'title' => 'Cultura'],
            ['type' => StrategicContextTypeEnum::INTERNAL->value, 'title' => 'Estrategia'],
            // Externo
            ['type' => StrategicContextTypeEnum::EXTERNAL->value, 'title' => 'Político'],
            ['type' => StrategicContextTypeEnum::EXTERNAL->value, 'title' => 'Económico'],
            ['type' => StrategicContextTypeEnum::EXTERNAL->value, 'title' => 'Social'],
            ['type' => StrategicContextTypeEnum::EXTERNAL->value, 'title' => 'Tecnológico'],
            ['type' => StrategicContextTypeEnum::EXTERNAL->value, 'title' => 'Ecológico/Ambiental'],
            ['type' => StrategicContextTypeEnum::EXTERNAL->value, 'title' => 'Legal'],
        ];

        foreach ($strategicContexts as $strategicContext) {
            StrategicContext::create($strategicContext);
        }
    }
}
