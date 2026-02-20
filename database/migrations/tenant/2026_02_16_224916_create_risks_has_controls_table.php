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
        Schema::create('risks_has_controls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_id')->constrained('risks')->onDelete('cascade');
            $table->foreignId('control_id')->constrained('controls')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks_has_controls');
    }
};
