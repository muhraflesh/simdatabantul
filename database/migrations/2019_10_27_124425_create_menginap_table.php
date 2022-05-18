<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenginapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menginap', function (Blueprint $table) {
            $table->increments('id');

            $table->date('tanggal');
            $table->string('asal_kota_wisatawan');
            $table->integer('lama_menginap');
            $table->integer('jumlah_menginap')->default(1);
            $table->string('foto');
            $table->enum('tipe_menginap', ['nusantara', 'mancanegara']);

            $table->integer('akomodasi_id')->unsigned();
            $table->foreign('akomodasi_id')
            ->references('id')->on('akomodasi')
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
