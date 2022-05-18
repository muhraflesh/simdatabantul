<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add role
        $roles = [
            [
                'name' => 'superadmin',
                'display_name' => 'Superadmin',
                'description' => 'Only one and only superadmin',
            ],
            [
                'name' => 'operator',
                'display_name' => 'Operator Wisata',
                'description' => 'Access for Operator Wisata',
            ],
            [
                'name' => 'operator_hotel',
                'display_name' => 'Operator Hotel',
                'description' => 'Access for Operator Hotel',
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}