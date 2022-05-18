<?php

use Illuminate\Database\Seeder;

class HotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = [
            [
                'nama_hotel'       => 'Hotel Del Luna',
                'alamat_hotel'     => 'Dimaana ya lupa lagi',
                'kontak_hotel'     => '085327133223',
                'email_hotel'      => 'contact@delluna.com',
                'jenis_hotel'      => 'bintang',
                'user_id'          => 4
            ]
        ];

        DB::table('hotel')->insert($a);
    }
}
