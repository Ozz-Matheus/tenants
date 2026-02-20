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
        Schema::create('legal_requirements', function (Blueprint $table) {
            $table->id();
            // $table->string('system')->nullable();
            $table->string('type')->nullable();
            $table->string('name');
            $table->date('publication_date')->nullable();
            $table->string('issuer')->nullable();
            $table->string('article')->nullable();
            $table->text('description')->nullable();
            $table->string('application_evidence_path')->nullable();
            $table->string('topic')->nullable();
            $table->foreignId('responsible_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('process_id')->nullable()->constrained('processes')->nullOnDelete();
            $table->integer('review_frequency_days')->nullable();
            $table->date('last_review')->nullable();
            $table->date('next_review')->nullable();
            $table->string('validity')->nullable();
            $table->string('status')->nullable();
            $table->string('compliance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_requirements');
    }
};
