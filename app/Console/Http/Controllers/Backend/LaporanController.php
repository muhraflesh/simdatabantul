<?php
namespace App\Http\Controllers\Backend;

/*
 * @Author      : Ferdhika Yudira 
 * @Date        : 2017-07-18 14:17:32 
 * @Web         : http://dika.web.id
 * @FileName    : HomeController.php
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\WisataKunjungan;
use Excel;
use Carbon\Carbon;
use App\Utils\LaporanDownload;

class LaporanController extends Controller{

    public $routePath = "backend::laporan";
    public $prefix = "backend.laporan";

    public function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.laporan';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function desawisata(Request $request){
        $data['page_name'] = "Laporan Wisatawan Desa Wisata";
        $data['page_description'] = "Laporan wisatawan desa wisata";

        $user = Auth::user();
        $result = [];

        // Superadmin
        if(\Auth::user()->hasRole('superadmin')){
            $result = \App\WisataKunjungan::whereHas('wisata', function($query){
                $query->where('tipe_wisata', 'desa');
            })->groupBy('wisata_id')->get();
        }elseif(\Auth::user()->hasRole('operator')){
            $result = \App\WisataKunjungan::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
            ->whereHas('wisata', function($query){
                $query->where('tipe_wisata', 'desa');
            })->groupBy('wisata_id')->get();
        }

        $data['data'] = $result;

        // download
        if($request->waktuTipe && $request->download){
            $download = new LaporanDownload;
            if(\Auth::user()->hasRole('superadmin')){
                $download->downloadDesa($request, $result);
            }else if(\Auth::user()->hasRole('operator')){
                $download->downloadOperatorDesa($request, $result);
            }
        }

        return view($this->prefix.'.desawisata', $data);
    }

    public function obyekwisata(Request $request){
        $data['page_name'] = "Laporan Wisatawan Obyek Wisata";
        $data['page_description'] = "Laporan wisatawan obyek wisata";

        $user = Auth::user();
        $result = [];

        // Superadmin
        if(\Auth::user()->hasRole('superadmin')){
            $result = \App\WisataKunjungan::whereHas('wisata', function($query){
                $query->where('tipe_wisata', 'obyek');
            })->groupBy('wisata_id')->get();
        }elseif(\Auth::user()->hasRole('operator')){
            $result = \App\WisataKunjungan::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
            ->whereHas('wisata', function($query){
                $query->where('tipe_wisata', 'obyek');
            })->groupBy('wisata_id')->get();
        }

        $data['data'] = $result;

        // download
        if($request->waktuTipe && $request->download){
            $download = new \App\Utils\LaporanDownload\ObyekWisata;
            if(\Auth::user()->hasRole('superadmin')){
                $download->downloadObyek($request, $result);
            }else if(\Auth::user()->hasRole('operator')){
                $download->downloadOperatorObyek($request, $result);
            }
        }

        return view($this->prefix.'.obyekwisata', $data);
    }

    public function belanja(Request $request){
        $data['page_name'] = "Laporan Wisatawan Belanja";
        $data['page_description'] = "Laporan wisatawan belanja";

        $user = Auth::user();
        $result = [];

        // Superadmin
        if(\Auth::user()->hasRole('superadmin')){
            $result = \App\Belanja::groupBy('wisata_id')->get();
        }elseif(\Auth::user()->hasRole('operator')){
            $result = \App\Belanja::where('wisata_id', \Auth::user()->pengelola[0]->wisata_id)
            ->groupBy('wisata_id')->get();
        }

        $data['data'] = $result;

        // download
        if($request->waktuTipe && $request->download){
            $download = new \App\Utils\LaporanDownload\Belanja;
            if(\Auth::user()->hasRole('superadmin')){
                $download->downloadBelanja($request, $result);
            }else if(\Auth::user()->hasRole('operator')){
                $download->downloadOperatorBelanja($request, $result);
            }
        }

        return view($this->prefix.'.belanja', $data);
    }

    public function hotelBelanja(Request $request){
        $data['page_name'] = "Laporan Wisatawan Hotel Belanja";
        $data['page_description'] = "Laporan wisatawan hotel belanja";

        $user = Auth::user();
        $result = [];

        // Superadmin
        if(\Auth::user()->hasRole('superadmin')){
            $result = \App\HotelBelanja::groupBy('hotel_id')->get();
        }elseif(\Auth::user()->hasRole('operator_hotel')){
            $result = \App\HotelBelanja::where('hotel_id', \Auth::user()->hotel->id)
            ->groupBy('hotel_id')->get();
        }
        
        $data['data'] = $result;

        // download
        if($request->waktuTipe && $request->download){
            $download = new \App\Utils\LaporanDownload\HotelBelanja;
            if(\Auth::user()->hasRole('superadmin')){
                $download->downloadBelanja($request, $result);
            }else if(\Auth::user()->hasRole('operator_hotel')){
                $download->downloadOperatorBelanja($request, $result);
            }
        }

        return view($this->prefix.'.hotel_belanja', $data);
    }

    public function homestay(Request $request){
        $data['page_name'] = "Laporan Homestay";
        $data['page_description'] = "Laporan homestay";

        $user = Auth::user();
        $result = [];

        // Superadmin
        if(\Auth::user()->hasRole('superadmin')){
            $result = \App\Menginap::join('akomodasi', 'menginap.akomodasi_id', '=', 'akomodasi.id')->orderBy('akomodasi.wisata_id', 'asc')->select('menginap.*')->groupBy('akomodasi_id')->get();
        }elseif(\Auth::user()->hasRole('operator')){
            $result = \App\Menginap::join('akomodasi', 'menginap.akomodasi_id', '=', 'akomodasi.id')->orderBy('akomodasi.wisata_id', 'asc')->select('menginap.*')->groupBy('akomodasi_id')->where('wisata_id', \Auth::user()->pengelola[0]->wisata->id)->get();
        }
        $data['data'] = $result;

        // download
        if($request->waktuTipe && $request->download){
            $download = new \App\Utils\LaporanDownload\Homestay;
            if(\Auth::user()->hasRole('superadmin')){
                $download->downloadHomestay($request, $result);
            }else if(\Auth::user()->hasRole('operator')){
                $download->downloadOperatorHomestay($request, $result);
            }
        }

        return view($this->prefix.'.homestay', $data);
    }

    public function hotel(Request $request){
        $data['page_name'] = "Laporan Hotel";
        $data['page_description'] = "Laporan hotel";

        $user = Auth::user();
        $result = [];

        // Superadmin
        if(\Auth::user()->hasRole('superadmin')){
            $result = \App\HotelKamar::groupBy('hotel_id')->get();
        }elseif(\Auth::user()->hasRole('operator_hotel')){
            $result = \App\HotelKamar::where('hotel_id', \Auth::user()->hotel->id)->groupBy('hotel_id')->get();
        }

        $data['data'] = $result;

        // download
        if($request->waktuTipe && $request->download){
            $download = new \App\Utils\LaporanDownload\Hotel;
            if(\Auth::user()->hasRole('superadmin')){
                $download->downloadHotel($request, $result);
            }else if(\Auth::user()->hasRole('operator_hotel')){
                $download->downloadOperatorHotel($request, $result);
            }
        }

        return view($this->prefix.'.hotel', $data);
    }
}