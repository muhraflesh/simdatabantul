<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 120);
            $table->text('alamat')->nullable();
            $table->string('foto');
            $table->time('jam_buka')->nullable();
            $table->time('jam_tutup')->nullable();

            $table->integer('kelurahan_id')->unsigned();
            $table->foreign('kelurahan_id')
            ->references('id')->on('kelurahan')
            ->onDelete('cascade');

            $table->enum('tipe_wisata', ['obyek', 'desa']);

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
        Schema::dropIfExists('wisata');
    }
}
