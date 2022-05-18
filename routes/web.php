<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/successregis', function () {
    return view('successregis');
});

$router->group([
    'prefix'     => 'template_doc', 
    'as'         => 'template_doc.'
    ], function ($router) {
        Route::get('/', 'TemplateDocController@index')->name('index');
        Route::get('/{name?}', 'TemplateDocController@download')->name('download')->where('name', '(.*)');
});

Route::get('/refresh_captcha', function () {
    return response()->json(['captcha'=> captcha_img()]);
})->name('refresh_captcha');

// Routing backend administrator
$router->group([
    'namespace'  => 'Backend',
    'prefix'     => config('larakuy.prefix_admin', 'backend'), 
    'as'         => 'backend::',
    'middleware' => 'auth'
    ], function ($router) {
    
    // Dashboard
    Route::get('/dashboard', 'HomeController@index')->middleware('role:superadmin|operator|operator_hotel', 'pengelola:*')->name('dashboard');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/change', 'ProfileController@edit')->name('profile.edit');
    Route::patch('/profile/change', 'ProfileController@update')->name('profile.update');
    Route::get('/pengelola', 'PengelolaController@index')->name('pengelola');
    Route::get('/pengelola/create', 'PengelolaController@create')->name('pengelola.create');
    Route::post('/pengelola/create', 'PengelolaController@store')->name('pengelola.store');
    Route::get('/pengelola/change', 'PengelolaController@edit')->name('pengelola.edit');
    Route::patch('/pengelola/change', 'PengelolaController@update')->name('pengelola.update');
    Route::delete('/pengelola/{idUser}/{idWisata}/delete', 'PengelolaController@destroy')->name('destroy');
       
    // Master
    $router->group([
        'namespace'  => 'Master',
        'prefix'     => 'master', 
        'as'         => 'master.',
        'middleware' => ['role:superadmin']
        ], function ($router) {
            // Obyek Wisata
            $router->group([
                'prefix'     => 'obyek_wisata', 
                'as'         => 'obyek_wisata.'
                ], function ($router) {
                    Route::get('/', 'ObyekWisataController@index')->name('index');
                    Route::get('/create', 'ObyekWisataController@create')->name('create');
                    Route::post('/create', 'ObyekWisataController@store')->name('store');
                    Route::get('/{id}/edit', 'ObyekWisataController@edit')->name('edit');
                    Route::patch('/{id}/edit', 'ObyekWisataController@update')->name('update');
                    Route::delete('/{id}/delete', 'ObyekWisataController@destroy')->name('destroy');
                    Route::patch('/{id}/active', 'ObyekWisataController@active')->name('active');
            });

            // Desa Wisata
            $router->group([
                'prefix'     => 'desa_wisata', 
                'as'         => 'desa_wisata.'
                ], function ($router) {
                    Route::get('/', 'DesaWisataController@index')->name('index');
                    Route::get('/create', 'DesaWisataController@create')->name('create');
                    Route::post('/create', 'DesaWisataController@store')->name('store');
                    Route::get('/{id}/edit', 'DesaWisataController@edit')->name('edit');
                    Route::patch('/{id}/edit', 'DesaWisataController@update')->name('update');
                    Route::delete('/{id}/delete', 'DesaWisataController@destroy')->name('destroy');
                    Route::patch('/{id}/active', 'DesaWisataController@active')->name('active');
            });

            // Hotel
            $router->group([
                'prefix'     => 'hotel', 
                'as'         => 'hotel.'
                ], function ($router) {
                    Route::get('/', 'HotelController@index')->name('index');
                    Route::get('/create', 'HotelController@create')->name('create');
                    Route::post('/create', 'HotelController@store')->name('store');
                    Route::get('/{id}/edit', 'HotelController@edit')->name('edit');
                    Route::patch('/{id}/edit', 'HotelController@update')->name('update');
                    Route::delete('/{id}/delete', 'HotelController@destroy')->name('destroy');
            });

            // // Akomodasi
            // $router->group([
            //     'prefix'     => 'akomodasi', 
            //     'as'         => 'akomodasi.'
            //     ], function ($router) {
            //         Route::get('/', 'AkomodasiController@index')->name('index');
            //         Route::get('/create', 'AkomodasiController@create')->name('create');
            //         Route::post('/create', 'AkomodasiController@store')->name('store');
            //         Route::get('/{id}/edit', 'AkomodasiController@edit')->name('edit');
            //         Route::patch('/{id}/edit', 'AkomodasiController@update')->name('update');
            //         Route::delete('/{id}/delete', 'AkomodasiController@destroy')->name('destroy');
            //         Route::patch('/{id}/active', 'AkomodasiController@active')->name('active');
            // });
        }
    );

    // Akomodasi
    $router->group([
        'namespace'  => 'Master',
        'prefix'     => 'master/akomodasi', 
        'as'         => 'master.akomodasi.',
        'middleware' => ['role:operator|superadmin', 'pengelola:desa']
        ], function ($router) {
            Route::get('/', 'AkomodasiController@index')->name('index');
            Route::get('/create', 'AkomodasiController@create')->name('create');
            Route::post('/create', 'AkomodasiController@store')->name('store');
            Route::get('/{id}/edit', 'AkomodasiController@edit')->name('edit');
            Route::patch('/{id}/edit', 'AkomodasiController@update')->name('update');
            Route::delete('/{id}/delete', 'AkomodasiController@destroy')->name('destroy');
            Route::patch('/{id}/active', 'AkomodasiController@active')->name('active');
    });

    // Jenis Kamar
    $router->group([
        'namespace'  => 'Master',
        'prefix'     => 'master/jenis_kamar', 
        'as'         => 'master.jenis_kamar.',
        'middleware' => ['role:operator_hotel']
        ], function ($router) {
            Route::get('/', 'JenisKamarController@index')->name('index');
            Route::get('/create', 'JenisKamarController@create')->name('create');
            Route::post('/create', 'JenisKamarController@store')->name('store');
            Route::get('/{id}/edit', 'JenisKamarController@edit')->name('edit');
            Route::patch('/{id}/edit', 'JenisKamarController@update')->name('update');
            Route::delete('/{id}/delete', 'JenisKamarController@destroy')->name('destroy');
    });
    
    $router->group([
        'prefix'     => 'hotel_fasilitas', 
        'as'         => 'hotel_fasilitas.',
        'middleware' => ['role:operator_hotel']
        ], function ($router) {
            Route::get('/', 'HotelFasilitasController@index')->name('index');
            Route::get('/create', 'HotelFasilitasController@create')->name('create');
            Route::post('/create', 'HotelFasilitasController@store')->name('store');
            Route::get('/{id}/edit', 'HotelFasilitasController@edit')->name('edit');
            Route::patch('/{id}/edit', 'HotelFasilitasController@update')->name('update');
            Route::delete('/{id}/delete', 'HotelFasilitasController@destroy')->name('destroy');
    });

    $router->group([
        'prefix'     => 'fasilitas_umum', 
        'as'         => 'fasilitas_umum.',
        'middleware' => ['role:operator', 'pengelola:*']
        ], function ($router) {
            Route::get('/', 'FasilitasUmumController@index')->name('index');
            Route::get('/create', 'FasilitasUmumController@create')->name('create');
            Route::post('/create', 'FasilitasUmumController@store')->name('store');
            Route::get('/{id}/edit', 'FasilitasUmumController@edit')->name('edit');
            Route::patch('/{id}/edit', 'FasilitasUmumController@update')->name('update');
            Route::delete('/{id}/delete', 'FasilitasUmumController@destroy')->name('destroy');
    });

    $router->group([
        'prefix'     => 'hotel_paket_wisata', 
        'as'         => 'hotel_paket_wisata.',
        'middleware' => ['role:operator_hotel']
        ], function ($router) {
            Route::get('/', 'HotelPaketWisataController@index')->name('index');
            Route::get('/create', 'HotelPaketWisataController@create')->name('create');
            Route::post('/create', 'HotelPaketWisataController@store')->name('store');
            Route::get('/{id}/edit', 'HotelPaketWisataController@edit')->name('edit');
            Route::patch('/{id}/edit', 'HotelPaketWisataController@update')->name('update');
            Route::delete('/{id}/delete', 'HotelPaketWisataController@destroy')->name('destroy');
    });

    $router->group([
        'prefix'     => 'wisata_paket', 
        'as'         => 'wisata_paket.',
        'middleware' => ['role:operator', 'pengelola:desa']
        ], function ($router) {
            Route::get('/', 'WisataPaketController@index')->name('index');
            Route::get('/create', 'WisataPaketController@create')->name('create');
            Route::post('/create', 'WisataPaketController@store')->name('store');
            Route::get('/{id}/edit', 'WisataPaketController@edit')->name('edit');
            Route::patch('/{id}/edit', 'WisataPaketController@update')->name('update');
            Route::delete('/{id}/delete', 'WisataPaketController@destroy')->name('destroy');
    });

    // Kunjungan
    $router->group([
        'namespace'  => 'Kunjungan',
        'prefix'     => 'kunjungan', 
        'as'         => 'kunjungan.',
        'middleware' => ['role:superadmin|operator']
        ], function ($router) {
            // Desa Wisata
            $router->group([
                'prefix'     => 'desa_wisata', 
                'as'         => 'desa_wisata.',
                'middleware' => ['pengelola:desa']
                ], function ($router) {
                    Route::get('/{tipe}', 'DesaWisataController@index')->name('index');
                    Route::get('/{tipe}/create', 'DesaWisataController@create')->name('create');
                    Route::post('/{tipe}/create', 'DesaWisataController@store')->name('store');
                    Route::get('/{tipe}/{id}/edit', 'DesaWisataController@edit')->name('edit');
                    Route::patch('/{tipe}/{id}/edit', 'DesaWisataController@update')->name('update');
                    Route::delete('/{tipe}/{id}/delete', 'DesaWisataController@destroy')->name('destroy');
            });

            // Obyek Wisata
            $router->group([
                'prefix'     => 'obyek_wisata', 
                'as'         => 'obyek_wisata.',
                'middleware' => ['pengelola:obyek']
                ], function ($router) {
                    Route::get('/{tipe}', 'ObyekWisataController@index')->name('index');
                    Route::get('/{tipe}/create', 'ObyekWisataController@create')->name('create');
                    Route::post('/{tipe}/create', 'ObyekWisataController@store')->name('store');
                    Route::get('/{tipe}/{id}/edit', 'ObyekWisataController@edit')->name('edit');
                    Route::patch('/{tipe}/{id}/edit', 'ObyekWisataController@update')->name('update');
                    Route::delete('/{tipe}/{id}/delete', 'ObyekWisataController@destroy')->name('destroy');
            });
        }
    );

    // Menginap (Akomodasi)
    $router->group([
        'namespace'  => 'Menginap',
        'prefix'     => 'menginap', 
        'as'         => 'menginap.',
        'middleware' => ['role:superadmin|operator', 'pengelola:desa']
        ], function ($router) {
            Route::get('/{tipe}', 'AkomodasiController@index')->name('index');
            Route::get('/{tipe}/create', 'AkomodasiController@create')->name('create');
            Route::post('/{tipe}/create', 'AkomodasiController@store')->name('store');
            Route::get('/{tipe}/{id}/edit', 'AkomodasiController@edit')->name('edit');
            Route::patch('/{tipe}/{id}/edit', 'AkomodasiController@update')->name('update');
            Route::delete('/{tipe}/{id}/delete', 'AkomodasiController@destroy')->name('destroy');
        }
    );

    // Menginap Hotel
    $router->group([
        'namespace'  => 'Menginap',
        'prefix'     => 'menginap_hotel', 
        'as'         => 'menginap_hotel.',
        'middleware' => ['role:superadmin|operator_hotel']
        ], function ($router) {
            Route::get('/{tipe}', 'HotelController@index')->name('index');
            Route::get('/{tipe}/create', 'HotelController@create')->name('create');
            Route::post('/{tipe}/create', 'HotelController@store')->name('store');
            Route::get('/{tipe}/{id}/edit', 'HotelController@edit')->name('edit');
            Route::patch('/{tipe}/{id}/edit', 'HotelController@update')->name('update');
            Route::delete('/{tipe}/{id}/delete', 'HotelController@destroy')->name('destroy');
        }
    );

    // Belanja
    $router->group([
        'prefix'     => 'hotel_belanja', 
        'as'         => 'hotel_belanja.',
        'middleware' => ['role:superadmin|operator_hotel']
        ], function ($router) {
            Route::get('/{tipe}', 'HotelBelanjaController@index')->name('index');
            Route::get('/{tipe}/create', 'HotelBelanjaController@create')->name('create');
            Route::post('/{tipe}/create', 'HotelBelanjaController@store')->name('store');
            Route::get('/{tipe}/{id}/edit', 'HotelBelanjaController@edit')->name('edit');
            Route::patch('/{tipe}/{id}/edit', 'HotelBelanjaController@update')->name('update');
            Route::delete('/{tipe}/{id}/delete', 'HotelBelanjaController@destroy')->name('destroy');
        }
    );

    $router->group([
        'prefix'     => 'belanja', 
        'as'         => 'belanja.',
        'middleware' => ['role:superadmin|operator', 'pengelola:desa']
        ], function ($router) {
            Route::get('/{tipe}', 'BelanjaController@index')->name('index');
            Route::get('/{tipe}/create', 'BelanjaController@create')->name('create');
            Route::post('/{tipe}/create', 'BelanjaController@store')->name('store');
            Route::get('/{tipe}/{id}/edit', 'BelanjaController@edit')->name('edit');
            Route::patch('/{tipe}/{id}/edit', 'BelanjaController@update')->name('update');
            Route::delete('/{tipe}/{id}/delete', 'BelanjaController@destroy')->name('destroy');
        }
    );

    // Laporan
    $router->group([
        'prefix'     => 'laporan', 
        'as'         => 'laporan.',
        'middleware' => ['role:superadmin|operator_hotel|operator', 'pengelola:*']
        ], function ($router) {
            Route::get('/desawisata', 'LaporanController@desawisata')->middleware('role:superadmin|operator', 'pengelola:desa')->name('desa');
            Route::get('/obyekwisata', 'LaporanController@obyekwisata')->middleware('role:superadmin|operator', 'pengelola:obyek')->name('obyek');
            Route::get('/belanja', 'LaporanController@belanja')->middleware('role:superadmin|operator', 'pengelola:desa')->name('belanja');
            Route::get('/homestay', 'LaporanController@homestay')->middleware('role:superadmin|operator', 'pengelola:desa')->name('homestay');
            Route::get('/hotel', 'LaporanController@hotel')->middleware('role:superadmin|operator_hotel')->name('hotel');
            Route::get('/hotel_belanja', 'LaporanController@hotelBelanja')->middleware('role:superadmin|operator_hotel')->name('hotel_belanja');
    });

    // Pengelola
    $router->group([
        'namespace'  => 'Pengelola',
        'prefix'     => 'pengelola', 
        'as'         => 'pengelola.',
        'middleware' => ['role:superadmin']
        ], function ($router) {
            // Desa Wisata
            $router->group([
                'prefix'     => 'desa_wisata', 
                'as'         => 'desa_wisata.'
                ], function ($router) {
                    Route::get('/', 'DesaWisataController@index')->name('index');
                    Route::get('/create', 'DesaWisataController@create')->name('create');
                    Route::post('/create', 'DesaWisataController@store')->name('store');
                    Route::get('/{id}/edit', 'DesaWisataController@edit')->name('edit');
                    Route::patch('/{id}/edit', 'DesaWisataController@update')->name('update');
                    Route::delete('/{id}/delete', 'DesaWisataController@destroy')->name('destroy');
                    Route::patch('/{id}/active', 'DesaWisataController@active')->name('active');
            });

            // Obyek Wisata
            $router->group([
                'prefix'     => 'obyek_wisata', 
                'as'         => 'obyek_wisata.'
                ], function ($router) {
                    Route::get('/', 'ObyekWisataController@index')->name('index');
                    Route::get('/create', 'ObyekWisataController@create')->name('create');
                    Route::post('/create', 'ObyekWisataController@store')->name('store');
                    Route::get('/{id}/edit', 'ObyekWisataController@edit')->name('edit');
                    Route::patch('/{id}/edit', 'ObyekWisataController@update')->name('update');
                    Route::delete('/{id}/delete', 'ObyekWisataController@destroy')->name('destroy');
                    Route::patch('/{id}/active', 'ObyekWisataController@active')->name('active');
            });
        }
    );

    // Pengguna
    $router->group([
        'prefix'     => 'pengguna', 
        'as'         => 'pengguna.',
        'middleware' => ['role:superadmin']
        ], function ($router) {
            Route::get('/', 'PenggunaController@index')->name('index');
            Route::get('/create', 'PenggunaController@create')->name('create');
            Route::post('/create', 'PenggunaController@store')->name('store');
            Route::get('/{id}/edit', 'PenggunaController@edit')->name('edit');
            Route::patch('/{id}/edit', 'PenggunaController@update')->name('update');
            Route::delete('/{id}/delete', 'PenggunaController@destroy')->name('destroy');
            Route::post('/{id}/bukablokir', 'PenggunaController@bukablokir')->name('bukablokir');
            Route::patch('/{id}/active', 'PenggunaController@active')->name('active');
    });
     
    // Approval
    $router->group([
        'prefix'     => 'approval', 
        'as'         => 'approval.',
        'middleware' => ['role:superadmin']
        ], function ($router) {
            Route::get('/', 'ApprovalController@index')->name('index');
            Route::get('/{id}/edit', 'ApprovalController@edit')->name('edit');
            Route::patch('/{id}/edit', 'ApprovalController@update')->name('update');
    });
});

Route::get('/getKelurahan/{id}', function ($id) {
    $data = \App\Kelurahan::where('kecamatan_id', $id)->get();
    return $data;
})->name('getKelurahan');

Route::get('/getWisata/{tipe}', function ($tipe) {
    $pengelolas = \DB::table('pengelola')->select('wisata_id')->get();
    $p = [];
    foreach($pengelolas as $pengelola){
        array_push($p, $pengelola->wisata_id);
    }
    $data = \App\Wisata::where('tipe_wisata', $tipe)
    // ->whereNotIn('id', $p)
    ->get();

    return $data;
})->name('getWisata');

Route::get('/getAkomodasi/{wisata}', function ($wisata) {
    $data = \App\Akomodasi::with('kategori')->where('wisata_id', $wisata)->get();

    return $data;
})->name('getAkomodasi');

Route::get('/getHotelByJenis/{jenis}', function ($jenis) {
    $data = \App\Hotel::where('jenis_hotel', $jenis)->get();

    return $data;
})->name('getHotelByJenis');

Route::get('/getKamarHotel/{idHotel}', function ($idHotel) {
    $data = \App\HotelKamar::where('hotel_id', $idHotel)->get();

    return $data;
})->name('getKamarHotel');

Route::get('/getListHotelPaketWisata/{idHotel}', function ($idHotel) {
    if(empty($idHotel)){
        $idHotel = \Auth::user()->hotel->id;
    }
    $data = \App\HotelPaketWisata::where('hotel_id', $idHotel)->get();

    return $data;
})->name('getListHotelPaketWisata');

Route::get('/getListPaketWisata/{idWisata}', function ($idWisata) {
    if(empty($idWisata)){
        $idWisata = \Auth::user()->pengelola[0]->wisata_id;
    }
    $data = \App\WisataPaket::where('wisata_id', $idWisata)->get();

    return $data;
})->name('getListPaketWisata');