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
        Schema::create('effectiveness_level_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('effectiveness_level');
            $table->integer('min_rating')->comment('Calificación mínima para este nivel de efectividad');
            $table->integer('max_rating')->comment('Calificación máxima para este nivel de efectividad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('effectiveness_level_ranges');
    }
};
