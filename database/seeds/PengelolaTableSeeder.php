<?php

use Illuminate\Database\Seeder;

class PengelolaTableSeeder extends Seeder
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
                'user_id'          => 3,
                'wisata_id'        => 1
            ],
            [
                'user_id'          => 2,
                'wisata_id'        => 3
            ]
        ];

        DB::table('pengelola')->insert($a);
    }
}
