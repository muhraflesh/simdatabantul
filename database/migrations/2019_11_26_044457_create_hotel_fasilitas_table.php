<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelFasilitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_fasilitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->string('foto');

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
        Schema::dropIfExists('hotel_fasilitas');
    }
}
