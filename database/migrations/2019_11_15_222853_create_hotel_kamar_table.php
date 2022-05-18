<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelKamarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_kamar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jenis_kamar', 120)->nullable();
            $table->integer('harga_permalam');
            $table->text('keterangan');

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
        Schema::dropIfExists('hotel_kamar');
    }
}
