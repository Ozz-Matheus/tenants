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
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('process_id')->constrained();
            $table->foreignId('subprocess_id')->constrained();
            $table->integer('risk_type');
            $table->integer('strategic_context_type');
            $table->foreignId('inherent_impact_id')->constrained('evaluation_criterias');
            $table->foreignId('inherent_probability_id')->constrained('evaluation_criterias');
            $table->foreignId('inherent_level_id')->constrained('evaluation_criterias');

            // Aca viene la parte del residual que se colocará mas adelante
            $table->integer('treatment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
