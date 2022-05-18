<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelMenginapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_menginap', function (Blueprint $table) {
            $table->increments('id');

            $table->date('tanggal');
            $table->integer('lama_menginap')->default(1);
            $table->integer('jumlah_menginap')->default(1);
            $table->enum('tipe_menginap', ['nusantara', 'mancanegara']);
            $table->string('harga_perkamar')->nullable();
            $table->string('total')->nullable();

            $table->integer('hotel_kamar_id')->unsigned();
            $table->foreign('hotel_kamar_id')
            ->references('id')->on('hotel_kamar')
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
        Schema::dropIfExists('hotel_menginap');
    }
}
