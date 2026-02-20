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
        Schema::create('interested_parties', function (Blueprint $table) {
            $table->id();
            $table->date('identification_date');
            $table->string('name');
            // $table->enum('classification', ['internal', 'external']);
            $table->string('classification');
            $table->text('needs')->nullable();
            $table->text('expectations')->nullable();
            $table->text('communication_mechanisms')->nullable();
            $table->foreignId('responsible_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->integer('communication_frequency_days')->nullable();
            $table->date('last_communication')->nullable();
            $table->date('next_communication')->nullable();
            $table->string('applicable_management_system')->nullable();
            $table->foreignId('legal_requirement_id')->nullable()->constrained('legal_requirements')->nullOnDelete();
            $table->foreignId('process_id')->nullable()->constrained('processes')->nullOnDelete();
            $table->string('section')->nullable();
            $table->json('stakeholder_attributes')->nullable();
            $table->string('qualification_level')->nullable();
            $table->json('compliance_level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interested_parties');
    }
};
