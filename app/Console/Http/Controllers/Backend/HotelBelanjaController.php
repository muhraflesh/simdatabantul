<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-26 10:28:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\HotelBelanja;
use App\HotelBelanjaPaketWisata;
use App\HotelBelanjaFoto;
use App\Akomodasi;
use App\Hotel;
use App\HotelPaketWisata;

class HotelBelanjaController extends Controller{

    public $routePath = "backend::hotel_belanja";
    public $prefix = "backend.hotel_belanja";

    function __construct(){
        $this->prefix = 'backend.hotel_belanja';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipe){
        $data['page_name'] = "Belanja Wisatawan ".ucwords($tipe);
        $data['page_description'] = "Data Belanja Wisatawan ".ucwords($tipe);

        $user = \Auth::user();

        if(!empty($request->cari)){
            if($user->hasRole('operator_hotel')){
                $res = HotelBelanja::where('tipe_belanja', $tipe)
                ->whereHas('hotel', function ($query) use ($request) {
                    $query->where('nama_hotel', 'like', '%'.$request->nama.'%')
                    ->whereNull('deleted_at');
                })
                ->where('hotel_id', $user->hotel->id);
                if(!empty($request->kategori)){
                    $res->where('kategori_belanja', $request->kategori);
                }
                $res->whereNull('deleted_at')
                ->orderBy('created_at', 'asc');
                
                $model = $res->paginate(10);
            }else{
                $res = HotelBelanja::where('tipe_belanja', $tipe)
                ->whereHas('hotel', function ($query) use ($request) {
                    $query->where('nama_hotel', 'like', '%'.$request->nama.'%')
                    ->whereNull('deleted_at');
                });
                if(!empty($request->kategori)){
                $res->where('kategori_belanja', $request->kategori);
                }
                $res->whereNull('deleted_at')
                ->orderBy('created_at', 'asc');

                $model = $res->paginate(10);
            }
        }else{
            if($user->hasRole('operator_hotel')){
                $model = HotelBelanja::where('tipe_belanja', $tipe)
                ->where('hotel_id', $user->hotel->id)
                ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }else{
                $model = HotelBelanja::where('tipe_belanja', $tipe)
                ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }
        }

        $data['data'] = $model;
        $data['tipe_wisata'] = $tipe;
        
        return view($this->prefix.'.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $tipe){
        $data['page_name'] = "Belanja Wisatawan ".ucwords($tipe);
        $data['page_description'] = "Buat belanja wisatawan baru";
        $data['data'] = new HotelBelanja;
        $data['tipe_wisata'] = $tipe;

        return view($this->prefix.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $tipe){
        // validasi form
        $this->validate($request, [
            'tanggal'       => 'required|string',
            'total_belanja' => 'required|integer',
            'jumlah_orang'  => 'required|integer',
            'url_foto.*'    => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
        ]);

        if($request->kategori=='paketwisata'){
            $this->validate($request, [
                'wisata_paket'     => 'required|integer',
            ]);
        }

        $user = \Auth::user();
        
        if($user->hasRole('superadmin')){
            $this->validate($request, [
                'hotel' => 'required'
            ]);
        }

        // // upload foto
        // $gambar = $request->file('foto');
        // $gambarName = str_replace(" ","_",$request->input('tanggal')).time().'.'.$gambar->getClientOriginalExtension();
        // $gambar->move(public_path("/uploads/belanja/"), $gambarName);
        // $request->request->add([
        //     'file'     => 'uploads/belanja/'.$gambarName
        // ]);
        
        if($user->hasRole('superadmin')){
            $hotel = Hotel::findOrFail($request->hotel);
        }else{
            $hotel = Hotel::findOrFail($user->hotel->id);
        }

        $belanja = new HotelBelanja;
        $belanja->tanggal = $request->tanggal;
        $belanja->total_belanja = $request->total_belanja;
        $belanja->jumlah_orang = $request->jumlah_orang;
        $belanja->kategori_belanja = $request->kategori;
        $belanja->hotel()->associate($hotel);
        // $belanja->foto = $request->file;
        $belanja->foto = 'uploads/default.jpg';
        $belanja->tipe_belanja = $tipe;
        $belanja->save();

        // belanja wisata paket
        if($request->kategori=='paketwisata'){
            $wisataPaket = HotelPaketWisata::findOrFail($request->wisata_paket);
            $belanjaPaket = new HotelBelanjaPaketWisata;
            $belanjaPaket->belanja()->associate($belanja);
            $belanjaPaket->paketWisata()->associate($wisataPaket);
            $belanjaPaket->save();
        }

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
                
                $judul = strtolower(str_replace(" ","_",$request->input('tanggal')).time());

                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    // $gambarName = str_replace(" ","_",$request->input('judul')).time().'.'.$gambar->getClientOriginalExtension();
                    $gambarName = time().str_replace(" ","_",$gambar->getClientOriginalName());
                    $gambar->move(public_path("/uploads/hotel_belanja/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/hotel_belanja/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/hotel_belanja/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new HotelBelanjaFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->belanja()->associate($belanja);
        
                $ft->save();
            }
        }

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $tipe, $id){
        $data = HotelBelanja::findOrFail($id);

        $parse['page_name'] = "Ubah Belanja Wisatawan ".ucwords($tipe);
        $parse['page_description'] = "Ubah Belanja Wisatawan ".ucwords($tipe);
        $parse['data'] = $data;
        $parse['tipe_wisata'] = $tipe;
        $parse['fotos'] = HotelBelanjaFoto::where('hotel_belanja_id', $id)->get();

        return view($this->prefix.'.edit', $parse);
    }

    /**
     * Update the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tipe, $id){
        // validasi form
        $this->validate($request, [
            'tanggal' => 'required|string',
            'total_belanja'     => 'required|integer',
            'jumlah_orang'     => 'required|integer'
        ]);
        
        if($request->kategori=='paketwisata'){
            $this->validate($request, [
                'wisata_paket'     => 'required|integer',
            ]);
        }
        
        $user = \Auth::user();

        if($user->hasRole('superadmin')){
            $this->validate($request, [
                'hotel' => 'required'
            ]);
        }

        // upload gambar
        // $gambar = $request->file('foto');
        // if(!empty($gambar)){
        //     $this->validate($request, [
        //         'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ]);

        //     $gambarName = str_replace(" ","_",$request->input('tanggal')).time().'.'.$gambar->getClientOriginalExtension();
        //     $gambar->move(public_path("/uploads/hotel_belanja/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/hotel_belanja/'.$gambarName
        //     ]);
        // }

        if($user->hasRole('superadmin')){
            $hotel = Hotel::findOrFail($request->hotel);
        }else{
            $hotel = Hotel::findOrFail($user->hotel->id);
        }

        $belanja = HotelBelanja::findOrFail($id);
        $belanja->tanggal = $request->tanggal;
        $belanja->total_belanja = $request->total_belanja;
        $belanja->jumlah_orang = $request->jumlah_orang;
        $belanja->kategori_belanja = $request->kategori;
        $belanja->hotel()->associate($hotel);
        // cover ga dipake
        if(!empty($request->file)){
            $belanja->foto = $request->file;
        }

        // belanja wisata paket
        if($request->kategori=='paketwisata'){
            // delete dulu nu sebelumna
            $delBWP = HotelBelanjaPaketWisata::where('hotel_belanja_id', $id)->where('hotel_paket_wisata_id', $request->wisata_paket)->first();
            $delBWP->forceDelete();

            // buat lagi
            $wisataPaket = HotelPaketWisata::findOrFail($request->wisata_paket);
            $belanjaPaket = new HotelBelanjaPaketWisata;
            $belanjaPaket->belanja()->associate($belanja);
            $belanjaPaket->paketWisata()->associate($wisataPaket);
            $belanjaPaket->save();
        }

        // delete foto yg sebelumnya
        $delFoto = HotelBelanjaFoto::where('hotel_belanja_id',$id)->get();
        foreach($delFoto as $df){
            $df->forceDelete();
        }

        // upload foto
        if(!empty($request->foto)){
            $this->validate($request, [
                'url_foto.*'    => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
            ]);

            foreach($request->foto as $foto){
            
                $judul = strtolower(str_replace(" ","_",$request->input('tanggal')).time());
    
                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    $gambarName = str_replace(" ","_",$request->input('nik')).time().'.'.$gambar->getClientOriginalExtension();
    
                    $gambar->move(public_path("/uploads/hotel_belanja/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/hotel_belanja/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/hotel_belanja/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new HotelBelanjaFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->belanja()->associate($belanja);
        
                $ft->save();
            }
        }

        $belanja->save();

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di ubah.");
    }

    /**
     * Delete the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $tipe, $id){
        $data = HotelBelanja::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di hapus.");
    }
}