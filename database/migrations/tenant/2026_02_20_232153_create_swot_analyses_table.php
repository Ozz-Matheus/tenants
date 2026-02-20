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
        Schema::create('swot_analyses', function (Blueprint $table) {
            $table->id();
            $table->string('environment');
            $table->string('type');
            $table->string('factor')->nullable();
            $table->string('description');
            $table->integer('criticality')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swot_analyses');
    }
};
