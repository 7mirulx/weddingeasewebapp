<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_ratings', function (Blueprint $table) {
            // Add booking_id
            $table->bigInteger('booking_id')->after('vendor_id');

            // Add foreign key (optional but recommended)
            $table->foreign('booking_id')
                  ->references('id')->on('bookings')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('vendor_ratings', function (Blueprint $table) {
            // Drop FK first
            $table->dropForeign(['booking_id']);

            // Drop column
            $table->dropColumn('booking_id');
        });
    }
};
