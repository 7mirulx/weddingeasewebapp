<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prerequisite_steps', function (Blueprint $table) {
            $table->id();

            // unique key untuk logic (kursus, hiv, borang, wali, kelulusan, akad)
            $table->string('code')->unique();

            // display
            $table->string('name');
            $table->text('description')->nullable();

            // behaviour flags
            $table->boolean('requires_document')->default(false);
            $table->boolean('requires_expiry')->default(false);

            // order dalam UI / flow
            $table->unsignedInteger('step_order');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prerequisite_steps');
    }
};
