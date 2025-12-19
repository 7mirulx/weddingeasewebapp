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
        Schema::table('bookings', function (Blueprint $table) {
            // Status of the booking from vendor perspective
            $table->enum('status', ['prospect', 'contacted', 'ready', 'completed'])
                  ->default('prospect')
                  ->after('vendor_id');
            
            // Agreed price between vendor and client
            $table->decimal('agreed_price', 10, 2)->nullable()->after('payment_progress');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['status', 'agreed_price']);
        });
    }
};
