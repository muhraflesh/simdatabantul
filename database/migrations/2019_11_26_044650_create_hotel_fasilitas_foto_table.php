<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelFasilitasFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_fasilitas_foto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_foto', 100)->nullable();
            $table->string('url_foto', 100);

            $table->integer('hotel_fasilitas_id')->unsigned();
            $table->foreign('hotel_fasilitas_id')
            ->references('id')->on('hotel_fasilitas')
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
        Schema::dropIfExists('hotel_fasilitas_foto');
    }
}
