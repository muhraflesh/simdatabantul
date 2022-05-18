<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => "Ferdhika Yudira",
        //     'email' => 'rpl4rt08@gmail.com',
        //     'password' => bcrypt('bandung0'),
        //     'created_at'	=> date('Y-m-d h:i:s'),
        //     'updated_at'	=> date('Y-m-d h:i:s'),
        // ]);
        $users = [
            [
                'name' => 'superadmin',
                'email' => 'superadmin@example.com',
                'password' => bcrypt('superadmin'),
                'created_at'	=> date('Y-m-d h:i:s'),
                'updated_at'	=> date('Y-m-d h:i:s'),
                'username' => 'superadmin',
                'status'    => true
            ],
            [
                'name' => 'Operator Obyek Wisata',
                'email' => 'ow@example.com',
                'password' => bcrypt('123456'),
                'created_at'	=> date('Y-m-d h:i:s'),
                'updated_at'	=> date('Y-m-d h:i:s'),
                'username' => 'ow',
                'status'    => true
            ],
            [
                'name' => "Operator Desa Wisata",
                'email' => 'dw@example.com',
                'password' => bcrypt('123456'),
                'created_at'	=> date('Y-m-d h:i:s'),
                'updated_at'	=> date('Y-m-d h:i:s'),
                'username'  => 'dw',
                'status'    => true
            ],
            [
                'name' => "Operator Hotel",
                'email' => 'hotel@example.com',
                'password' => bcrypt('123456'),
                'created_at'	=> date('Y-m-d h:i:s'),
                'updated_at'	=> date('Y-m-d h:i:s'),
                'username'  => 'hotel',
                'status'    => true
            ]
        ];

        DB::table('users')->insert($users);

        $user=User::where('email','=','superadmin@example.com')->first();
        $user->attachRole(1);
        $user=User::where('email','=','ow@example.com')->first();
        $user->attachRole(2);
        $user=User::where('email','=','dw@example.com')->first();
        $user->attachRole(2);
        $user=User::where('email','=','hotel@example.com')->first();
        $user->attachRole(3);
    }
}
