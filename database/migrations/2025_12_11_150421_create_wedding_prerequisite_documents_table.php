<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_prerequisite_documents', function (Blueprint $table) {
            $table->id();

            // RELATION TO USER STEP (wedding_prerequisites)
            $table->foreignId('wedding_prerequisite_id')
                ->constrained()
                ->cascadeOnDelete();

            /**
             * TYPE OF DOCUMENT
             * Example: kursus, hiv, borang, wali, kelulusan
             * (redundant but useful for filtering & debugging)
             */
            $table->string('type');

            // FILE STORAGE
            $table->string('file_path');
            $table->string('original_name');

            // METADATA
            $table->date('uploaded_at')->nullable();
            $table->date('expires_at')->nullable(); // useful for HIV expiry

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_prerequisite_documents');
    }
};
