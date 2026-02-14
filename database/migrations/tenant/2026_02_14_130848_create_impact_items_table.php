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
        Schema::create('impact_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained();
            $table->foreignId('strategic_context_id')->constrained();
            $table->string('description');
            $table->string('value_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impact_items');
    }
};
