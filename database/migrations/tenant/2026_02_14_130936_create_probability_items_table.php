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
        Schema::create('probability_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained();
            $table->foreignId('cause_id')->constrained();
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
        Schema::dropIfExists('probability_items');
    }
};
