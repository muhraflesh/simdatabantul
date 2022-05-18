<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBelanjaPaketWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belanja_wisata_paket', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('belanja_id')->unsigned();
            $table->foreign('belanja_id')
            ->references('id')->on('belanja')
            ->onDelete('cascade');
            $table->integer('wisata_paket_id')->unsigned();
            $table->foreign('wisata_paket_id')
            ->references('id')->on('wisata_paket')
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
        Schema::dropIfExists('belanja_wisata_paket');
    }
}
