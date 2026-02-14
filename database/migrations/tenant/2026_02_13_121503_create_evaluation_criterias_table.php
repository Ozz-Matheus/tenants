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
        Schema::create('evaluation_criterias', function (Blueprint $table) {
            $table->id();
            $table->integer('context_type')->comment('Si es impacto, probabilidad o nivel de riesgo.');
            $table->string('title');
            $table->string('description');
            $table->integer('min');
            $table->integer('max');
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_criterias');
    }
};
