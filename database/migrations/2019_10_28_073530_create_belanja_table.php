<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBelanjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('belanja', function (Blueprint $table) {
            $table->increments('id');

            $table->date('tanggal');
            $table->integer('jumlah_orang');
            $table->integer('total_belanja')->default(0);
            $table->string('foto');
            $table->enum('tipe_belanja', ['nusantara', 'mancanegara'])->default('nusantara');
            $table->enum('kategori_belanja', ['kuliner', 'oleholeh', 'transportasi', 'paketwisata'])->default('kuliner');

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
        Schema::dropIfExists('menginap');
    }
}
