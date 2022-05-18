<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAkomodasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akomodasi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_akomodasi', 250);
            $table->string('nama_pemilik', 250);
            $table->text('alamat')->nullable();
            $table->string('kontak', 13);
            $table->integer('jumlah_kamar');
            $table->string('harga_kamar')->nullable(0);
            
            $table->integer('akomodasi_kategori_id')->unsigned();
            $table->foreign('akomodasi_kategori_id')
            ->references('id')->on('akomodasi_kategori')
            ->onDelete('cascade');

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
        Schema::dropIfExists('akomodasi');
    }
}
