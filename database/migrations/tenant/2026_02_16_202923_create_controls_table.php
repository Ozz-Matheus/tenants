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
        Schema::create('controls', function (Blueprint $table) {
            $table->id();
            $table->string('nature_of_control'); // Preventivo, Detectivo, Correctivo
            $table->string('title');
            $table->text('description');
            $table->string('automation_level')->comment('Nivel de automatización del control'); // Manual, Semi-automatizado, Automatizado
            $table->string('frequency')->comment('Frecuencia con la que se realiza el control'); // Diario, Semanal, Mensual, Trimestral, Anual
            $table->foreignId('responsible_id')->constrained('users');
            $table->integer('effectiveness_rating');
            $table->string('effectiveness_level');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controls');
    }
};
