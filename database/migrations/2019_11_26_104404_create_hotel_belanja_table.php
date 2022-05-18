<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelBelanjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_belanja', function (Blueprint $table) {
            $table->increments('id');

            $table->date('tanggal');
            $table->integer('jumlah_orang');
            $table->integer('total_belanja')->default(0);
            $table->string('foto');
            $table->enum('tipe_belanja', ['nusantara', 'mancanegara'])->default('nusantara');
            $table->enum('kategori_belanja', ['kuliner', 'oleholeh', 'transportasi', 'paketwisata'])->default('kuliner');

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
        Schema::dropIfExists('hotel_belanja');
    }
}
