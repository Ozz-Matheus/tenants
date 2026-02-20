<?php

namespace Database\Seeders;

use App\Enums\CriteriaTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use App\Models\ItemValue;
use Illuminate\Database\Seeder;

class ItemValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            /* Para Impacto */

            // Estructura

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 1, 'title' => 'Bajo', 'value' => 10, 'description' => 'Pequeñas desalineaciones en funciones o procesos que no afectan significativamente la operación.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 1, 'title' => 'Leve', 'value' => 30, 'description' => 'Desajustes menores en roles o procesos que generan ligeros inconvenientes operativos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 1, 'title' => 'Medio', 'value' => 60, 'description' => 'Deficiencias en roles, responsabilidades o procesos que generan retrasos operativos importantes.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 1, 'title' => 'Alto', 'value' => 80, 'description' => 'Problemas significativos en la estructura que afectan la coordinación y ejecución de proyectos críticos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 1, 'title' => 'Crítico', 'value' => 100, 'description' => 'Fallas críticas en la estructura organizacional que paralizan operaciones o afectan objetivos estratégicos.'],

            // Recursos

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 2, 'title' => 'Bajo', 'value' => 10, 'description' => 'Limitaciones leves de recursos que pueden resolverse con ajustes internos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 2, 'title' => 'Leve', 'value' => 30, 'description' => 'Falta de recursos que genera retrasos menores pero manejables.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 2, 'title' => 'Medio', 'value' => 60, 'description' => 'Escasez significativa de recursos financieros, humanos o tecnológicos que afecta proyectos clave.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 2, 'title' => 'Alto', 'value' => 80, 'description' => 'Insuficiencia de recursos que impacta varias operaciones críticas y requiere intervención externa.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 2, 'title' => 'Crítico', 'value' => 100, 'description' => 'Falta crítica de recursos que compromete la sostenibilidad y cumplimiento estratégico.'],

            // Cultura

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 3, 'title' => 'Bajo', 'value' => 10, 'description' => 'Resistencias aisladas al cambio sin afectar el desempeño general.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 3, 'title' => 'Leve', 'value' => 30, 'description' => 'Problemas culturales leves que pueden afectar la colaboración en algunos equipos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 3, 'title' => 'Medio', 'value' => 60, 'description' => 'Problemas de clima organizacional que reducen productividad y compromiso.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 3, 'title' => 'Alto', 'value' => 80, 'description' => 'Conflictos culturales frecuentes que afectan múltiples áreas y decisiones estratégicas.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 3, 'title' => 'Crítico', 'value' => 100, 'description' => 'Crisis cultural que genera alta rotación, conflictos internos y bajo rendimiento general.'],

            // Estrategia

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 4, 'title' => 'Bajo', 'value' => 10, 'description' => 'Desviaciones menores en la planificación estratégica sin comprometer metas principales.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 4, 'title' => 'Leve', 'value' => 30, 'description' => 'Errores estratégicos leves que requieren ajustes sin afectar objetivos clave.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 4, 'title' => 'Medio', 'value' => 60, 'description' => 'Errores estratégicos que afectan competitividad o cumplimiento parcial de objetivos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 4, 'title' => 'Alto', 'value' => 80, 'description' => 'Decisiones estratégicas que afectan seriamente áreas críticas de la organización.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::INTERNAL, 'strategic_context_id' => 4, 'title' => 'Crítico', 'value' => 100, 'description' => 'Decisiones estratégicas erróneas que comprometen seriamente la viabilidad organizacional.'],

            // Político

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 5, 'title' => 'Bajo', 'value' => 10, 'description' => 'Cambios políticos menores sin efectos relevantes en la operación.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 5, 'title' => 'Leve', 'value' => 30, 'description' => 'Modificaciones regulatorias leves que requieren ajustes administrativos mínimos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 5, 'title' => 'Medio', 'value' => 60, 'description' => 'Modificaciones regulatorias que requieren ajustes operativos significativos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 5, 'title' => 'Alto', 'value' => 80, 'description' => 'Decisiones políticas que afectan significativamente la operación y estrategia.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 5, 'title' => 'Crítico', 'value' => 100, 'description' => 'Inestabilidad política o decisiones gubernamentales que afectan gravemente la continuidad del negocio.'],

            // Económico

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 6, 'title' => 'Bajo', 'value' => 10, 'description' => 'Variaciones económicas leves sin impacto considerable en resultados financieros.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 6, 'title' => 'Leve', 'value' => 30, 'description' => 'Cambios económicos moderados que generan pequeños ajustes en la planificación financiera.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 6, 'title' => 'Medio', 'value' => 60, 'description' => 'Inflación, tasas o mercado adverso que reducen márgenes y rentabilidad.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 6, 'title' => 'Alto', 'value' => 80, 'description' => 'Condiciones económicas difíciles que comprometen varios proyectos y resultados financieros.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 6, 'title' => 'Crítico', 'value' => 100, 'description' => 'Crisis económica severa que compromete liquidez y estabilidad financiera.'],

            // Social

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 7, 'title' => 'Bajo', 'value' => 10, 'description' => 'Cambios sociales menores sin alteraciones relevantes en la demanda.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 7, 'title' => 'Leve', 'value' => 30, 'description' => 'Tendencias sociales que afectan ligeramente la reputación o comportamiento del consumidor.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 7, 'title' => 'Medio', 'value' => 60, 'description' => 'Tendencias sociales que afectan reputación o comportamiento del consumidor.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 7, 'title' => 'Alto', 'value' => 80, 'description' => 'Cambios sociales que impactan directamente mercado, reputación o operaciones estratégicas.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 7, 'title' => 'Crítico', 'value' => 100, 'description' => 'Cambios sociales significativos que reducen mercado, reputación o sostenibilidad.'],

            // Tecnológico

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 8, 'title' => 'Bajo', 'value' => 10, 'description' => 'Actualizaciones tecnológicas menores sin interrupción operativa.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 8, 'title' => 'Leve', 'value' => 30, 'description' => 'Retrasos o fallas tecnológicas leves que afectan algunos procesos internos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 8, 'title' => 'Medio', 'value' => 60, 'description' => 'Fallas o rezago tecnológico que afectan eficiencia y competitividad.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 8, 'title' => 'Alto', 'value' => 80, 'description' => 'Problemas tecnológicos significativos que afectan operaciones críticas.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 8, 'title' => 'Crítico', 'value' => 100, 'description' => 'Ciberataques, obsolescencia crítica o fallas graves en sistemas que paralizan operaciones.'],

            // Ecológico/Ambiental

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 9, 'title' => 'Bajo', 'value' => 10, 'description' => 'Eventos ambientales menores sin daños materiales relevantes.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 9, 'title' => 'Leve', 'value' => 30, 'description' => 'Impactos ambientales moderados que generan costos menores o ajustes operativos.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 9, 'title' => 'Medio', 'value' => 60, 'description' => 'Eventos ambientales que afectan operaciones o generan costos adicionales.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 9, 'title' => 'Alto', 'value' => 80, 'description' => 'Eventos ambientales graves que impactan varias operaciones y requieren acciones externas.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 9, 'title' => 'Crítico', 'value' => 100, 'description' => 'Desastres naturales o sanciones ambientales que comprometen gravemente la operación.'],

            // Legal

            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 10, 'title' => 'Bajo', 'value' => 10, 'description' => 'Incumplimientos menores sin sanciones significativas.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 10, 'title' => 'Leve', 'value' => 30, 'description' => 'Pequeñas infracciones legales que requieren corrección interna.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 10, 'title' => 'Medio', 'value' => 60, 'description' => 'Procesos legales o sanciones moderadas que afectan recursos financieros.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 10, 'title' => 'Alto', 'value' => 80, 'description' => 'Problemas legales graves que impactan operaciones y requieren intervención externa.'],
            ['item_criteria_type' => CriteriaTypeEnum::IMPACT->value, 'strategic_context_type' => StrategicContextTypeEnum::EXTERNAL, 'strategic_context_id' => 10, 'title' => 'Crítico', 'value' => 100, 'description' => 'Demandas, multas o prohibiciones legales que ponen en riesgo la continuidad del negocio.'],

            /* Para Probabilidad */

            ['item_criteria_type' => CriteriaTypeEnum::PROBABILITY->value, 'title' => 'Muy Baja', 'value' => 10, 'description' => 'Ocurre en circunstancias excepcionales.'],
            ['item_criteria_type' => CriteriaTypeEnum::PROBABILITY->value, 'title' => 'Baja', 'value' => 30, 'description' => 'Puede ocurrir ocasionalmente.'],
            ['item_criteria_type' => CriteriaTypeEnum::PROBABILITY->value, 'title' => 'Media', 'value' => 60, 'description' => 'Existe una posibilidad real de ocurrencia.'],
            ['item_criteria_type' => CriteriaTypeEnum::PROBABILITY->value, 'title' => 'Alta', 'value' => 80, 'description' => 'Ocurre con frecuencia considerable.'],
            ['item_criteria_type' => CriteriaTypeEnum::PROBABILITY->value, 'title' => 'Muy Alta', 'value' => 100, 'description' => 'Es casi seguro que ocurra.'],
        ];
        foreach ($items as $item) {
            ItemValue::create($item);
        }
    }
}
