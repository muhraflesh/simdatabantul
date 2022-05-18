<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWisataKunjunganFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisata_kunjungan_foto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_foto', 100)->nullable();
            $table->string('url_foto', 100);

            $table->integer('wisata_kunjungan_id')->unsigned();
            $table->foreign('wisata_kunjungan_id')
            ->references('id')->on('wisata_kunjungan')
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
        Schema::dropIfExists('wisata_kunjungan_foto');
    }
}
