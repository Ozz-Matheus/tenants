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
        Schema::create('sub_processes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('acronym');
            $table->foreignId('process_id')->constrained()->onDelete('cascade');
            $table->foreignId('leader_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_processes');
    }
};
