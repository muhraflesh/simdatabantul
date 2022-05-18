<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWisataPaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisata_paket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->text('keterangan');
            $table->integer('harga')->default(0);

            $table->integer('wisata_id')->unsigned();
            $table->foreign('wisata_id')
            ->references('id')->on('wisata')
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
        Schema::dropIfExists('wisata_paket');
    }
}
