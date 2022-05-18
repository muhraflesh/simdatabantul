<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenginapFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menginap_foto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_foto', 100)->nullable();
            $table->string('url_foto', 100);

            $table->integer('menginap_id')->unsigned();
            $table->foreign('menginap_id')
            ->references('id')->on('menginap')
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
        Schema::dropIfExists('menginap_foto');
    }
}
