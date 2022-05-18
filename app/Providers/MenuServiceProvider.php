<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Lavary\Menu\Builder;
use App\Classes\Menu;

class MenuServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if ($this->app->bound('larakuy.superadmin.menu')) {
            $menuDashboard = $this->app['larakuy.superadmin.menu']
                ->add(trans('Dashboard'), url('backend/dashboard'))
                ->data('icon', 'settings_input_svideo')
                ->data('id', 'larakuy-dashboard');
                
            $menuMulti = $this->app['larakuy.superadmin.menu']
                ->add(trans('Master Data'))
                ->data('icon', 'business_center')
                ->data('id', 'larakuy-multi');    
            $menuMulti->add(trans('Obyek Wisata'), url('backend/master/obyek_wisata'))->data('icon', 'radio_button_unchecked');
            $menuMulti->add(trans('Desa Wisata'), url('backend/master/desa_wisata'))->data('icon', 'radio_button_unchecked');
            $menuMulti->add(trans('Akomodasi'), url('backend/master/akomodasi'))->data('icon', 'radio_button_unchecked');

            $menuDesaWisata = $this->app['larakuy.superadmin.menu']
                ->add(trans('Desa Wisata'), url('backend/dashboard'))
                ->data('icon', 'directions')
                ->data('id', 'larakuy-desa-wisata');
            $menuDesaWisata->add(trans('Wisatawan Mancanegara'), url('backend/kunjungan/desa_wisata/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuDesaWisata->add(trans('Wisatawan Nusantara'), url('backend/kunjungan/desa_wisata/nusantara'))->data('icon', 'radio_button_unchecked');

            $menuMenginap = $this->app['larakuy.superadmin.menu']
                ->add(trans('Menginap'), url('backend/dashboard'))
                ->data('icon', 'hotel')
                ->data('id', 'larakuy-akomodasi');
            $menuMenginap->add(trans('Wisatawan Mancanegara'), url('backend/menginap/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuMenginap->add(trans('Wisatawan Nusantara'), url('backend/menginap/nusantara'))->data('icon', 'radio_button_unchecked');

            $menuBelanja = $this->app['larakuy.superadmin.menu']
                ->add(trans('Belanja'))
                ->data('icon', 'shopping_basket')
                ->data('id', 'larakuy-belanja');    
            $menuBelanja->add(trans('Wisatawan Mancanegara'), url('backend/belanja/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuBelanja->add(trans('Wisatawan Nusantara'), url('backend/belanja/nusantara'))->data('icon', 'radio_button_unchecked');

            $menuObyekWisata = $this->app['larakuy.superadmin.menu']
                ->add(trans('Obyek Wisata'), url('backend/dashboard'))
                ->data('icon', 'directions')
                ->data('id', 'larakuy-obyek-wisata');
            $menuObyekWisata->add(trans('Wisatawan Mancanegara'), url('backend/kunjungan/obyek_wisata/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuObyekWisata->add(trans('Wisatawan Nusantara'), url('backend/kunjungan/obyek_wisata/nusantara'))->data('icon', 'radio_button_unchecked');

            $menuLaporan = $this->app['larakuy.superadmin.menu']
                ->add(trans('Laporan'), url('backend/dashboard'))
                ->data('icon', 'insert_drive_file')
                ->data('id', 'larakuy-laporan');
            $menuLaporan->add(trans('Wisatawan Mancanegara'), url('backend/laporan/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuLaporan->add(trans('Wisatawan Nusantara'), url('backend/laporan/nusantara'))->data('icon', 'radio_button_unchecked');

            $menuPengelolaWisata = $this->app['larakuy.superadmin.menu']
                ->add(trans('Pengelola Wisata'), url('backend/dashboard'))
                ->data('icon', 'face')
                ->data('id', 'larakuy-pengelola');
            $menuPengelolaWisata->add(trans('Desa Wisata'), url('backend/pengelola/desa_wisata'))->data('icon', 'radio_button_unchecked');
            $menuPengelolaWisata->add(trans('Obyek Wisata'), url('backend/pengelola/obyek_wisata'))->data('icon', 'radio_button_unchecked');

            $menuManajemenPengguna = $this->app['larakuy.superadmin.menu']
                ->add(trans('Manajemen Pengguna'), url('backend/pengguna'))
                ->data('icon', 'face')
                ->data('id', 'larakuy-pengguna');

            $menuApproval = $this->app['larakuy.superadmin.menu']
                ->add(trans('Approval'), url('backend/approval'))
                ->data('icon', 'face')
                ->data('id', 'larakuy-approval');
        }

        if ($this->app->bound('larakuy.operator_ow.menu')) {
            $menuDashboard = $this->app['larakuy.operator_ow.menu']
                ->add(trans('Dashboard'), url('backend/dashboard'))
                ->data('icon', 'settings_input_svideo')
                ->data('id', 'larakuy-dashboard');
            $menuProfil = $this->app['larakuy.operator_ow.menu']
                    ->add(trans('Profil'), url('backend/profile'))
                    ->data('icon', 'face')
                    ->data('id', 'larakuy-profil');
            $menuPengelola = $this->app['larakuy.operator_ow.menu']
                ->add(trans('Pengelola'), url('backend/pengelola'))
                ->data('icon', 'face')
                ->data('id', 'larakuy-pengelola');
            $menuObyekWisata = $this->app['larakuy.operator_ow.menu']
                ->add(trans('Kunjungan'), url('backend/dashboard'))
                ->data('icon', 'settings_input_svideo')
                ->data('id', 'larakuy-kunjungan');
            $menuObyekWisata->add(trans('Wisatawan Mancanegara'), url('backend/kunjungan/obyek_wisata/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuObyekWisata->add(trans('Wisatawan Nusantara'), url('backend/kunjungan/obyek_wisata/nusantara'))->data('icon', 'radio_button_unchecked');
            
            $menuFasilitasUmum = $this->app['larakuy.operator_ow.menu']
                ->add(trans('Fasilitas Umum'), url('backend/fasilitas_umum'))
                ->data('icon', 'settings_input_composite')
                ->data('id', 'larakuy-fasilitas');

            $menuLaporan = $this->app['larakuy.operator_ow.menu']
                ->add(trans('Laporan'), url('backend/dashboard'))
                ->data('icon', 'insert_drive_file')
                ->data('id', 'larakuy-laporan');
            $menuLaporan->add(trans('Wisatawan Mancanegara'), url('backend/laporan/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuLaporan->add(trans('Wisatawan Nusantara'), url('backend/laporan/nusantara'))->data('icon', 'radio_button_unchecked');

        }

        if ($this->app->bound('larakuy.operator_dw.menu')) {
            $menuDashboard = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Dashboard'), url('backend/dashboard'))
                ->data('icon', 'settings_input_svideo')
                ->data('id', 'larakuy-dashboard');
            $menuProfil = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Profil'), url('backend/profile'))
                ->data('icon', 'face')
                ->data('id', 'larakuy-profil');
            $menuPengelola = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Pengelola'), url('backend/pengelola'))
                ->data('icon', 'face')
                ->data('id', 'larakuy-pengelola');
            $menuKunjungan = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Kunjungan'), url('backend/dashboard'))
                ->data('icon', 'directions')
                ->data('id', 'larakuy-kunjungan');
            $menuKunjungan->add(trans('Wisatawan Mancanegara'), url('backend/kunjungan/desa_wisata/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuKunjungan->add(trans('Wisatawan Nusantara'), url('backend/kunjungan/desa_wisata/nusantara'))->data('icon', 'radio_button_unchecked');
            
            $menuAkomodasi = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Akomodasi'), url('backend/master/akomodasi'))
                ->data('icon', 'business_center')
                ->data('id', 'larakuy-akomodasi');

            $menuFasilitasUmum = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Fasilitas Umum'), url('backend/fasilitas_umum'))
                ->data('icon', 'settings_input_composite')
                ->data('id', 'larakuy-fasilitas');
            
            $menuPaketWisata = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Paket Wisata'), url('backend/wisata_paket'))
                ->data('icon', 'card_travel')
                ->data('id', 'larakuy-paketwisata');
            
                $menuBelanja = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Belanja'))
                ->data('icon', 'shopping_basket')
                ->data('id', 'larakuy-belanja');    
            $menuBelanja->add(trans('Wisatawan Mancanegara'), url('backend/belanja/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuBelanja->add(trans('Wisatawan Nusantara'), url('backend/belanja/nusantara'))->data('icon', 'radio_button_unchecked');

            $menuMenginap = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Menginap'), url('backend/profil'))
                ->data('icon', 'hotel')
                ->data('id', 'larakuy-menginap');
            $menuMenginap->add(trans('Wisatawan Mancanegara'), url('backend/menginap/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuMenginap->add(trans('Wisatawan Nusantara'), url('backend/menginap/nusantara'))->data('icon', 'radio_button_unchecked');

            $menuLaporan = $this->app['larakuy.operator_dw.menu']
                ->add(trans('Laporan'), url('backend/dashboard'))
                ->data('icon', 'insert_drive_file')
                ->data('id', 'larakuy-laporan');
            $menuLaporan->add(trans('Wisatawan Mancanegara'), url('backend/laporan/mancanegara'))->data('icon', 'radio_button_unchecked');
            $menuLaporan->add(trans('Wisatawan Nusantara'), url('backend/laporan/nusantara'))->data('icon', 'radio_button_unchecked');
        }

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('larakuy.superadmin.menu', function(Application $app){
            return (new Menu())->make('sidebar', function(Builder $menu){
                return $menu;
            });
        });
        $this->app->singleton('larakuy.operator_ow.menu', function(Application $app){
            return (new Menu())->make('sidebar', function(Builder $menu){
                return $menu;
            });
        });
        $this->app->singleton('larakuy.operator_dw.menu', function(Application $app){
            return (new Menu())->make('sidebar', function(Builder $menu){
                return $menu;
            });
        });
    }
}
