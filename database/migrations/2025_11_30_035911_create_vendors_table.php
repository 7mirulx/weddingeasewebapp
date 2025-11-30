<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();

            // Basic details
            $table->string('vendor_name');
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->decimal('starting_price', 10, 2)->nullable();

            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Location
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();

            // Images
            $table->string('logo_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->json('gallery')->nullable();

            // Created by (user or admin)
            $table->enum('created_by_type', ['client', 'admin'])->default('client');
            $table->unsignedBigInteger('created_by_id');

            // Sponsored vendor
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_start')->nullable();
            $table->timestamp('featured_end')->nullable();

            // Rating summary
            $table->decimal('rating_average', 2, 1)->default(0);
            $table->integer('rating_count')->default(0);

            // Status
            $table->enum('status', ['active', 'inactive', 'pending'])
                  ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
