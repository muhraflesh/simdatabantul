<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWisataKunjunganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisata_kunjungan', function (Blueprint $table) {
            $table->increments('id');

            $table->date('tanggal');
            $table->integer('jumlah_wisatawan');
            $table->text('keterangan')->nullable();
            $table->string('foto');
            $table->enum('tipe_kunjungan', ['nusantara', 'mancanegara']);

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
        Schema::dropIfExists('wisata_kunjungan');
    }
}
