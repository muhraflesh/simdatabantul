<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WilayahTableSeeder::class);
        $this->call(AkomodasiKategoriTableSeeder::class);
        $this->call(WisataTableSeeder::class);
        $this->call(AkomodasiTableSeeder::class);
        $this->call(PengelolaTableSeeder::class);
        $this->call(HotelTableSeeder::class);
    }
}
