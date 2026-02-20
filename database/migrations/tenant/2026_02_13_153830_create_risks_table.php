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
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->string('classification_code')->unique();
            $table->string('title');
            $table->text('description');
            $table->foreignId('process_id')->constrained();
            $table->foreignId('subprocess_id')->constrained();
            $table->string('risk_type');
            $table->string('strategic_context_type');
            $table->foreignId('inherent_impact_id')->constrained('evaluation_criterias');
            $table->foreignId('inherent_probability_id')->constrained('evaluation_criterias');
            $table->foreignId('inherent_level_id')->constrained('evaluation_criterias');
            $table->string('treatment');
            $table->foreignId('residual_impact_id')->constrained('evaluation_criterias');
            $table->foreignId('residual_probability_id')->constrained('evaluation_criterias');
            $table->foreignId('residual_level_id')->constrained('evaluation_criterias');
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('headquarter_id')
                ->constrained()
                ->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
