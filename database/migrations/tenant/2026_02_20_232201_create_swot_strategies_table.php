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
        Schema::create('swot_strategies', function (Blueprint $table) {
            $table->id();
            $table->json('swot_elements_associated')->nullable();
            $table->string('type')->nullable();
            $table->string('strategy_type')->nullable();
            $table->string('strategy');
            $table->foreignId('risk_id')->nullable()->constrained('risks')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swot_strategies');
    }
};
