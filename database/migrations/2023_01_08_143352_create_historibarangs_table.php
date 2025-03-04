<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoribarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historibarangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('barang_id')->references('id')->on('barangs')->onDelete('CASCADE');
            $table->integer('status')->comment('1=masuk, 2=keluar, 3=rusak');
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
        Schema::dropIfExists('historibarangs');
    }
}
