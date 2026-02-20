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
        Schema::create('item_values', function (Blueprint $table) {
            $table->id();
            $table->string('item_criteria_type')->comment('Si es para el impacto o para la probabilidad');
            $table->string('strategic_context_type')->nullable()->comment('Solo si es impacto');
            $table->foreignId('strategic_context_id')->nullable()->comment('Solo si es impacto')->constrained();
            $table->string('title');
            $table->integer('value');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_values');
    }
};
