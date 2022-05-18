<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFasilitasUmumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas_umum', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();
            $table->string('foto');

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
        Schema::dropIfExists('fasilitas_umum');
    }
}
