<?php

use Illuminate\Database\Seeder;

class AkomodasiTableSeeder extends Seeder
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
                'nama_akomodasi'        => 'Ceria Homestay',
                'nama_pemilik'          => 'Deni',
                'alamat'                => 'Jln Warna Warni No 20',
                'kontak'                => '083213123777',
                'jumlah_kamar'          => 20,
                'harga_kamar'          => 200000,
                'akomodasi_kategori_id'  => 1,
                'wisata_id'           => 1
            ],
            [
                'nama_akomodasi'        => 'Deep Homestay',
                'nama_pemilik'          => 'Lucky',
                'alamat'                => 'Jln Warna Warni No 20',
                'kontak'                => '082413123777',
                'jumlah_kamar'          => 14,
                'harga_kamar'          => 100000,
                'akomodasi_kategori_id'  => 1,
                'wisata_id'           => 2
            ],
            [
                'nama_akomodasi'        => 'Deep Purple',
                'nama_pemilik'          => 'Anggas',
                'alamat'                => 'Jln Waruga No 20',
                'kontak'                => '085321232777',
                'jumlah_kamar'          => 31,
                'harga_kamar'          => 310000,
                'akomodasi_kategori_id'  => 1,
                'wisata_id'           => 1
            ],
            [
                'nama_akomodasi'        => 'Ceria Inap',
                'nama_pemilik'          => 'Bruno',
                'alamat'                => 'Jln Gerlong No 20',
                'kontak'                => '082321232788',
                'jumlah_kamar'          => 10,
                'harga_kamar'          => 210000,
                'akomodasi_kategori_id'  => 1,
                'wisata_id'           => 2
            ]
        ];

        DB::table('akomodasi')->insert($a);
    }
}
