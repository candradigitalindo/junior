<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookingorders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('booking_id')->references('id')->on('bookings')->onDelete('CASCADE');
            $table->string('product_name');
            $table->bigInteger('product_price');
            $table->bigInteger('discount')->default(0);
            $table->string('extraservice_name')->nullable();
            $table->bigInteger('extraservice_price')->default(0);
            $table->bigInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookingorders');
    }
}
