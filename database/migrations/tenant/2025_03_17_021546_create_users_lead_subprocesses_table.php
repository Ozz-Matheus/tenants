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
        Schema::create('users_lead_subprocesses', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subprocess_id')->constrained('subprocesses');

            $table->primary(['user_id', 'subprocess_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_lead_subprocesses');
    }
};
