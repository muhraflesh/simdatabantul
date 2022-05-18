<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_hotel', 120)->nullable();
            $table->string('alamat_hotel');
            $table->string('kontak_hotel', 13)->default('0831');
            $table->string('email_hotel')->unique();
            $table->enum('jenis_hotel', ['bintang', 'nonbintang'])->default('bintang');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users')
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
        Schema::dropIfExists('hotel');
    }
}
