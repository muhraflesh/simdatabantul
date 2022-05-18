<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFasilitasUmumFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas_umum_foto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_foto', 100)->nullable();
            $table->string('url_foto', 100);

            $table->integer('fasilitas_umum_id')->unsigned();
            $table->foreign('fasilitas_umum_id')
            ->references('id')->on('fasilitas_umum')
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
        Schema::dropIfExists('fasilitas_umum_foto');
    }
}
