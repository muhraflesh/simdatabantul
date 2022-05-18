<?php

use Illuminate\Database\Seeder;

class AkomodasiKategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Homestay',
                'created_at'	=> date('Y-m-d h:i:s'),
                'updated_at'	=> date('Y-m-d h:i:s'),
            ]
        ];

        DB::table('akomodasi_kategori')->insert($data);
    }
}
