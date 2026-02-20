<?php

namespace Database\Seeders;

use App\Enums\EffectivenessLevelEnum;
use App\Models\EffectivenessLevelRange;
use Illuminate\Database\Seeder;

class EffectivenessLevelRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['effectiveness_level' => EffectivenessLevelEnum::EFFECTIVE, 'min_rating' => 80, 'max_rating' => 100/* , 'color' => 'success' */],
            ['effectiveness_level' => EffectivenessLevelEnum::NEEDS_IMPROVEMENT, 'min_rating' => 50, 'max_rating' => 79/* , 'color' => 'warning' */],
            ['effectiveness_level' => EffectivenessLevelEnum::INEFFECTIVE, 'min_rating' => 0, 'max_rating' => 49/* , 'color' => 'danger' */],
        ];

        foreach ($levels as $level) {
            EffectivenessLevelRange::create($level);
        }
    }
}
