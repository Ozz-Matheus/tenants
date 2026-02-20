<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('control_id')->constrained('controls')->onDelete('cascade');
            $table->string('title');
            $table->foreignId('evaluator_id')->constrained('users')->onDelete('cascade'); // Usuario que realiza la evaluación

            // Pruebas (ToD y ToE)
            $table->boolean('design_is_suitable')->default(false)->comment('¿El diseño es apto?'); // Si, No
            // $table->integer('impact_reduction'); // Reducción del impacto cuando el control es correctivo
            // $table->integer('probability_reduction'); // Reducción de la probabilidad cuando el control es correctivo
            $table->integer('effectiveness_rating')->comment('Calificación de efectividad'); // Del 1 al 100 en porcentaje
            $table->string('effectiveness_level'); // efectivo, necesita mejora, inefectivo

            // Periodo evaluado
            $table->date('period_from');
            $table->date('period_to');

            // Hallazgos
            $table->text('observations')->nullable();
            $table->boolean('requires_rca')->default(false); // Solo se muestra si el nivel de efectividad es "Necesita mejora" o "In efectivo"

            $table->foreignId('created_by_id')->constrained('users');
            $table->foreignId('updated_by_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
