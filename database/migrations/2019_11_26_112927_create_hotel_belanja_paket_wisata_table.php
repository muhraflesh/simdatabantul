<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelBelanjaPaketWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_belanja_paket_wisata', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('hotel_belanja_id')->unsigned();
            $table->foreign('hotel_belanja_id')
            ->references('id')->on('hotel_belanja')
            ->onDelete('cascade');
            $table->integer('hotel_paket_wisata_id')->unsigned();
            $table->foreign('hotel_paket_wisata_id')
            ->references('id')->on('hotel_paket_wisata')
            ->onDelete('cascade');

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
        Schema::dropIfExists('hotel_belanja_paket_wisata');
    }
}
