<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_prerequisites', function (Blueprint $table) {
            $table->id();

            // RELATION TO USER
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // RELATION TO STEP (MASTER TABLE)
            $table->foreignId('prerequisite_step_id')
                ->constrained('prerequisite_steps')
                ->cascadeOnDelete();

            // WORKFLOW STATUS
            $table->enum('status', [
                'pending',
                'in_progress',
                'submitted',
                'completed',
                'approved',
                'rejected'
            ])->default('pending');

            // OPTIONAL TIMESTAMP
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // ENSURE 1 USER = 1 RECORD PER STEP
            $table->unique(['user_id', 'prerequisite_step_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_prerequisites');
    }
};
