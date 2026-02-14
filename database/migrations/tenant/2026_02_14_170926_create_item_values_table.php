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
            $table->integer('item_type')->comment('Basicamente si es un impacto o una probabilidad');
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
