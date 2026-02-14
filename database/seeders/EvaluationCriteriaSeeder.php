<?php

namespace Database\Seeders;

use App\Models\EvaluationCriteria;
use Illuminate\Database\Seeder;

class EvaluationCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criterias = [
            // Impacto
            [
                'context_type' => 1,
                'title' => 'Insignificante',
                'min' => 0,
                'max' => 10,
                'weight' => 50,
                'description' => 'Impacto mínimo en las operaciones. No afecta los objetivos estratégicos ni genera pérdidas significativas. Se gestiona dentro de las actividades normales.',
            ],
            [
                'context_type' => 1,
                'title' => 'Menor',
                'min' => 11,
                'max' => 30,
                'weight' => 100,
                'description' => 'Impacto leve en procesos específicos. Puede generar pequeños retrasos o pérdidas económicas bajas, sin comprometer objetivos estratégicos.',
            ],
            [
                'context_type' => 1,
                'title' => 'Moderado',
                'min' => 31,
                'max' => 60,
                'weight' => 200,
                'description' => 'Impacto considerable que afecta áreas importantes del negocio. Puede generar pérdidas financieras relevantes o incumplimientos parciales que requieren intervención.',
            ],
            [
                'context_type' => 1,
                'title' => 'Mayor',
                'min' => 61,
                'max' => 80,
                'weight' => 300,
                'description' => 'Impacto significativo que compromete el cumplimiento de objetivos estratégicos, genera pérdidas financieras altas o afecta la reputación institucional.',
            ],
            [
                'context_type' => 1,
                'title' => 'Crítico',
                'min' => 81,
                'max' => 100,
                'weight' => 400,
                'description' => 'Impacto severo que pone en riesgo la continuidad del negocio, genera pérdidas financieras muy altas, sanciones legales graves o daño reputacional considerable.',
            ],
            // Probabilidad
            [
                'context_type' => 2,
                'title' => 'Raro',
                'min' => 0,
                'max' => 20,
                'weight' => 0.2,
                'description' => 'Puede ocurrir solo en circunstancias excepcionales. No existen antecedentes recientes y su ocurrencia es altamente improbable.',
            ],
            [
                'context_type' => 2,
                'title' => 'Improbable',
                'min' => 21,
                'max' => 40,
                'weight' => 0.4,
                'description' => 'Es poco probable que ocurra, aunque podría presentarse en condiciones específicas. Existen antecedentes aislados.',
            ],
            [
                'context_type' => 2,
                'title' => 'Posible',
                'min' => 41,
                'max' => 60,
                'weight' => 0.6,
                'description' => 'Puede ocurrir en algún momento. Existen antecedentes documentados o condiciones que favorecen su materialización.',
            ],
            [
                'context_type' => 2,
                'title' => 'Probable',
                'min' => 61,
                'max' => 80,
                'weight' => 0.8,
                'description' => 'Ocurre con frecuencia moderada. Hay múltiples antecedentes o condiciones claras que incrementan significativamente su ocurrencia.',
            ],
            [
                'context_type' => 2,
                'title' => 'Casi Seguro',
                'min' => 81,
                'max' => 100,
                'weight' => 1,
                'description' => 'Se espera que ocurra en la mayoría de las circunstancias. Presenta antecedentes frecuentes o condiciones permanentes que lo propician.',
            ],
            // Nivel
            [
                'context_type' => 3,
                'title' => 'Bajo',
                'min' => 1,
                'max' => 39,
                'color' => 'success',
                'description' => 'Riesgo aceptable. No requiere acciones adicionales inmediatas, únicamente monitoreo periódico y mantenimiento de los controles existentes.',
            ],
            [
                'context_type' => 3,
                'title' => 'Medio',
                'min' => 40,
                'max' => 99,
                'color' => 'yellow',
                'description' => 'Riesgo moderado. Requiere seguimiento activo y la implementación de controles preventivos razonables para reducir su probabilidad o impacto.',
            ],
            [
                'context_type' => 3,
                'title' => 'Alto',
                'min' => 100,
                'max' => 239,
                'color' => 'warning',
                'description' => 'Riesgo significativo. Se deben implementar acciones correctivas prioritarias y establecer un plan formal de mitigación con responsables definidos.',
            ],
            [
                'context_type' => 3,
                'title' => 'Muy alto',
                'min' => 240,
                'max' => 400,
                'color' => 'danger',
                'description' => 'Riesgo crítico e inaceptable. Requiere intervención inmediata, acciones urgentes y posible suspensión de actividades hasta su reducción a un nivel tolerable.',
            ],
        ];

        foreach ($criterias as $criteria) {
            EvaluationCriteria::create($criteria);
        }
    }
}
