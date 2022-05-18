<?php

use Illuminate\Database\Seeder;

use App\Kecamatan;
use App\Kelurahan;

class WilayahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add wilayah
        $wilayahs = [
            [
                'kecamatan' => 'Srandakan',
                'kelurahan' => [
                    'Poncosari', 'Trimurti'
                ]
            ],
            [
                'kecamatan' => 'Sanden',
                'kelurahan' => [
                    'Gadingsari', 'Gadingharjo', 'Murtigading', 'Srigading'
                ]
            ],
            [
                'kecamatan' => 'Kretek',
                'kelurahan' => [
                    'Tirtohargo', 'Parangtritis', 'Tirtosari', 'Tirtomulyo', 'Donotirto'
                ]
            ],
            [
                'kecamatan' => 'Pundong',
                'kelurahan' => [
                    'Seloharjo', 'Panjangrejo', 'Srihardono'
                ]
            ],
            [
                'kecamatan' => 'Bambanglipuro',
                'kelurahan' => [
                    'Mulyodadi', 'Sidomulyo', 'Sumbermulyo'
                ]
            ],
            [
                'kecamatan' => 'Pandak',
                'kelurahan' => [
                    'Caturharjo', 'Triharjo', 'Gilangharjo', 'Wijirejo'
                ]
            ],
            [
                'kecamatan' => 'Bantul',
                'kelurahan' => [
                    'Palbapang', 'Trirenggo', 'Bantul', 'Sabdodadi', 'Ringinharjo'
                ]
            ],
            [
                'kecamatan' => 'Jetis',
                'kelurahan' => [
                    'Canden', 'Patalan', 'Sumberagung', 'Trimulyo'
                ]
            ],
            [
                'kecamatan' => 'Imogiri',
                'kelurahan' => [
                    'Girirejo', 'Imogiri', 'Karangtalun', 'Karangtengah', 'Kebonagung', 'Sriharjo', 'Wukirsari'
                ]
            ],
            [
                'kecamatan' => 'Dlingo',
                'kelurahan' => [
                    'Mangunan', 'Muntuk', 'Terong', 'Temuwuh', 'Jatimulyo', 'Dlingo'
                ]
            ],
            [
                'kecamatan' => 'Pleret',
                'kelurahan' => [
                    'Wonolelo', 'Bawuran', 'Pleret', 'Wonokromo', 'Segoroyoso'
                ]
            ],
            [
                'kecamatan' => 'Piyungan',
                'kelurahan' => [
                    'Srimulyo', 'Sitimulyo', 'Srimartani'
                ]
            ],
            [
                'kecamatan' => 'Banguntapan',
                'kelurahan' => [
                    'Banguntapan', 'Baturetno', 'Jagalan', 'Jambidan', 'Potorono', 'Singosaren', 'Tamanan', 'Wirokerten'
                ]
            ],
            [
                'kecamatan' => 'Sewon',
                'kelurahan' => [
                    'Bangunharjo', 'Panggungharjo', 'Pendowoharjo', 'Timbulharjo'
                ]
            ],
            [
                'kecamatan' => 'Kasihan',
                'kelurahan' => [
                    'Bangunjiwo', 'Ngestiharjo', 'Tamantirto', 'Tirtonirmolo'
                ]
            ],
            [
                'kecamatan' => 'Pajangan',
                'kelurahan' => [
                    'Guwosari', 'Sendangsari', 'Triwidadi'
                ]
            ],
            [
                'kecamatan' => 'Sedayu',
                'kelurahan' => [
                    'Argodadi', 'Argorejo', 'Argosari', 'Argomulyo'
                ]
            ],
        ];

        foreach($wilayahs as $wilayah){
            // $role = new Role(array('','','','')); // array of roles row values you want save
            // $user = User::find(1); // where 1 is id
            // $role = $user->roles()->save($role );

            $kecamatan = new Kecamatan;
            $kecamatan->nama = $wilayah['kecamatan'];
            $kecamatan->save();

            $kelurahans = [];
            foreach($wilayah['kelurahan'] as $kelurahan){
                array_push($kelurahans, new App\Kelurahan(['nama' => $kelurahan]));
            }
            $kecamatan->kelurahan()->saveMany($kelurahans);
        }

        // DB::table('kecamatan')->insert($kecamatan);

        // $kelurahan=User::where('email','=','superadmin@example.com')->first();
        // $user->attachRole(1);
    }
}
