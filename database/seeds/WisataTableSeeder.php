<?php

use Illuminate\Database\Seeder;

class WisataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wisata = [
            [
                'nama'          => 'Desa Warna',
                'alamat'        => 'Jln Warna Warni No 20',
                'foto'          => 'uploads/default.jpg',
                'jam_buka'      => '09:00',
                'kelurahan_id'  => 1,
                'tipe_wisata'   => 'desa'
            ],
            [
                'nama'          => 'Desa Penari',
                'alamat'        => 'Jln Penari No 1',
                'foto'          => 'uploads/default.jpg',
                'jam_buka'      => '09:00',
                'kelurahan_id'  => 1,
                'tipe_wisata'   => 'desa'
            ],
            [
                'nama'          => 'Curug Malela',
                'alamat'        => 'Jln malela No 2',
                'foto'          => 'uploads/default.jpg',
                'jam_buka'      => '08:00',
                'kelurahan_id'  => 2,
                'tipe_wisata'   => 'obyek'
            ],
            [
                'nama'          => 'Kebon Jagong',
                'alamat'        => 'Jln jagong rawi No 2',
                'foto'          => 'uploads/default.jpg',
                'jam_buka'      => '08:20',
                'kelurahan_id'  => 3,
                'tipe_wisata'   => 'obyek'
            ]
        ];

        DB::table('wisata')->insert($wisata);
    }
}
