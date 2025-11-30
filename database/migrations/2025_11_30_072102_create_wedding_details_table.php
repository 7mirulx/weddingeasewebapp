<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_details', function (Blueprint $table) {
            $table->id();

            // User reference
            $table->unsignedBigInteger('user_id');

            // Couple information
            $table->string('partner_name')->nullable();
            $table->date('wedding_date')->nullable();

            // Preferences
            $table->enum('preference_priority', [
                'budget',
                'quality',
                'balanced',
                'service',
                'popularity'
            ])->default('balanced');

            // Theme & size
            $table->string('wedding_theme')->nullable();
            $table->integer('wedding_size')->nullable(); // pax

            // Budget
            $table->decimal('budget', 10, 2)->nullable();

            // Venue area/state
            $table->string('venue_state')->nullable();

            // Timestamps (you said you don't need updated_at,
            // but Laravel migrations usually include both by default)
            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_details');
    }
};
