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
use App\Belanja;
use App\BelanjaWisataPaket;
use App\BelanjaFoto;
use App\Akomodasi;
use App\Wisata;
use App\WisataPaket;

class BelanjaController extends Controller{

    public $routePath = "backend::belanja";
    public $prefix = "backend.belanja";

    function __construct(){
        $this->prefix = 'backend.belanja';
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
            if($user->hasRole('operator')){
                $res = Belanja::where('tipe_belanja', $tipe)
                ->whereHas('wisata', function ($query) use ($request) {
                    $query->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('tipe_wisata', 'desa')
                    ->whereNull('deleted_at');
                })
                ->where('wisata_id', $user->pengelola[0]->wisata_id);
                if(!empty($request->kategori)){
                    $res->where('kategori_belanja', $request->kategori);
                }
                $res->whereNull('deleted_at')
                ->orderBy('created_at', 'asc');
                
                $model = $res->paginate(10);
            }else{
                $res = Belanja::where('tipe_belanja', $tipe)
                ->whereHas('wisata', function ($query) use ($request) {
                    $query->where('nama', 'like', '%'.$request->nama.'%')
                    ->where('tipe_wisata', 'desa')
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
            if($user->hasRole('operator')){
                $model = Belanja::where('tipe_belanja', $tipe)->whereHas('wisata', function ($query) use ($request) {
                    $query->where('tipe_wisata', 'desa')->whereNull('deleted_at');
                })
                ->where('wisata_id', $user->pengelola[0]->wisata_id)
                ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }else{
                $model = Belanja::where('tipe_belanja', $tipe)->whereHas('wisata', function ($query) use ($request) {
                    $query->where('tipe_wisata', 'desa')->whereNull('deleted_at');
                })->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
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
        $data['data'] = new Belanja;
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
                'wisata' => 'required'
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
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($request->wisata);
        }else{
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($user->pengelola[0]->wisata_id);
        }

        $belanja = new Belanja;
        $belanja->tanggal = $request->tanggal;
        $belanja->total_belanja = $request->total_belanja;
        $belanja->jumlah_orang = $request->jumlah_orang;
        $belanja->kategori_belanja = $request->kategori;
        $belanja->wisata()->associate($wisata);
        // $belanja->foto = $request->file;
        $belanja->foto = 'uploads/default.jpg';
        $belanja->tipe_belanja = $tipe;
        $belanja->save();

        // belanja wisata paket
        if($request->kategori=='paketwisata'){
            $wisataPaket = WisataPaket::findOrFail($request->wisata_paket);

            $belanjaPaket = new BelanjaWisataPaket;
            $belanjaPaket->belanja()->associate($belanja);
            $belanjaPaket->wisataPaket()->associate($wisataPaket);
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
                    $gambar->move(public_path("/uploads/belanja/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/belanja/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/belanja/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new BelanjaFoto;
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
        $data = Belanja::findOrFail($id);

        $parse['page_name'] = "Ubah Belanja Wisatawan ".ucwords($tipe);
        $parse['page_description'] = "Ubah Belanja Wisatawan ".ucwords($tipe);
        $parse['data'] = $data;
        $parse['tipe_wisata'] = $tipe;
        $parse['fotos'] = BelanjaFoto::where('belanja_id', $id)->get();

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

        $user = \Auth::user();

        if($request->kategori=='paketwisata'){
            $this->validate($request, [
                'wisata_paket'     => 'required|integer',
            ]);
        }
        if($user->hasRole('superadmin')){
            $this->validate($request, [
                'wisata' => 'required'
            ]);
        }

        // upload gambar
        // $gambar = $request->file('foto');
        // if(!empty($gambar)){
        //     $this->validate($request, [
        //         'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ]);

        //     $gambarName = str_replace(" ","_",$request->input('tanggal')).time().'.'.$gambar->getClientOriginalExtension();
        //     $gambar->move(public_path("/uploads/menginap/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/menginap/'.$gambarName
        //     ]);
        // }

        if($user->hasRole('superadmin')){
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($request->wisata);
        }else{
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($user->pengelola[0]->wisata_id);
        }

        $belanja = Belanja::findOrFail($id);
        $belanja->tanggal = $request->tanggal;
        $belanja->total_belanja = $request->total_belanja;
        $belanja->jumlah_orang = $request->jumlah_orang;
        $belanja->kategori_belanja = $request->kategori;
        $belanja->wisata()->associate($wisata);
        // cover ga dipake
        if(!empty($request->file)){
            $belanja->foto = $request->file;
        }

        // belanja wisata paket
        if($request->kategori=='paketwisata'){
            // delete dulu nu sebelumna
            $delBWP = BelanjaWisataPaket::where('belanja_id', $id)->where('wisata_paket_id', $request->wisata_paket)->first();
            $delBWP->forceDelete();

            // buat lagi
            $wisataPaket = WisataPaket::findOrFail($request->wisata_paket);
            $belanjaPaket = new BelanjaWisataPaket;
            $belanjaPaket->belanja()->associate($belanja);
            $belanjaPaket->wisataPaket()->associate($wisataPaket);
            $belanjaPaket->save();
        }

        // delete foto yg sebelumnya
        $delFoto = BelanjaFoto::where('belanja_id',$id)->get();
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
    
                    $gambar->move(public_path("/uploads/belanja/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/belanja/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/belanja/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new BelanjaFoto;
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
        $data = Belanja::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di hapus.");
    }
}