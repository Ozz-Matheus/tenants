<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $processes = [
            ['title' => 'Cadena de suministros'],
            ['title' => 'Calidad'],
            ['title' => 'Gestión financiera'],
            ['title' => 'Gestión humana'],
            ['title' => 'Investigación y desarrollo'],
        ];

        foreach ($processes as $process) {
            Process::create($process);
        }
    }
}
