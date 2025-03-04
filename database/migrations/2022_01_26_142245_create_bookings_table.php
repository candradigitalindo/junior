<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')->nullable();
            $table->string('no_pol_kendaraan');
            $table->string('tipe_mobil')->nullable();
            $table->string('phone');
            $table->string('name')->nullable();
            $table->date('tgl_booking');
            $table->time('waktu_booking');
            $table->timestamp('tgl_proses')->nullable();
            $table->timestamp('tgl_selesai')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Booking');
            $table->string('status_pembayaran')->default('Belum Bayar');
            $table->date('tgl_selesai_booking')->nullable();
            $table->time('waktu_selesai_booking')->nullable();
            $table->string('photo_tipe_mobil')->nullable();
            $table->string('status_kendaraan')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
