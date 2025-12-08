<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // siapa yang create booking
            $table->unsignedBigInteger('user_id');

            // vendor yang di-book
            $table->unsignedBigInteger('vendor_id');

            // progress payment dalam JSON
            // Contoh:
            // {
            //   "deposit": 1000,
            //   "payment2": 2000,
            //   "payment3": null
            // }
            $table->json('payment_progress')->nullable();

            // booking completed or pending
            $table->boolean('is_completed')->default(false);

            $table->timestamps();

            // relations
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }   
};
