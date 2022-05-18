<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelPaketWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_paket_wisata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->text('keterangan');
            $table->integer('harga')->default(0);

            $table->integer('hotel_id')->unsigned();
            $table->foreign('hotel_id')
            ->references('id')->on('hotel')
            ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotel_paket_wisata');
    }
}
