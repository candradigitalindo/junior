<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('booking_id')->references('id')->on('bookings')->onDelete('CASCADE');
            $table->string('invoice');
            $table->string('no_pol_kendaraan')->nullable();
            $table->string('tipe_mobil')->nullable();
            $table->string('product_name')->nullable();
            $table->bigInteger('product_price')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->date('tgl_bayar')->nullable();
            $table->text('keterangan')->nullable();
            $table->bigInteger('total')->nullable();
            $table->bigInteger('discount')->nullable();
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
        Schema::dropIfExists('transaksis');
    }
}
