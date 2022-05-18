<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-26 10:28:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Http\Controllers\Backend\Kunjungan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\WisataKunjungan;
use App\WisataKunjunganFoto;
use App\Wisata;
use App\Kecamatan;
use App\Kelurahan;

class ObyekWisataController extends Controller{

    public $routePath = "backend::kunjungan.obyek_wisata";
    public $prefix = "backend.kunjungan.obyek_wisata";

    function __construct(){
        $this->prefix = 'backend.kunjungan.obyek_wisata';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipe){
        $data['page_name'] = "Kunjungan Obyek Wisata ".ucwords($tipe);
        $data['page_description'] = "Data Kunjungan Obyek Wisata ".ucwords($tipe);

        $user = \Auth::user();

        if(!empty($request->nama)){

            if($user->hasRole('operator')){
                $model = WisataKunjungan::where('tipe_kunjungan', $tipe)
                ->whereHas('wisata', function ($query) use ($request) {
                    $query->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'obyek')->whereNull('deleted_at');
                })
                ->where('wisata_id', $user->pengelola[0]->wisata_id)
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }else{
                $model = WisataKunjungan::where('tipe_kunjungan', $tipe)
                ->whereHas('wisata', function ($query) use ($request) {
                    $query->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'obyek')->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }
        }else{
            
            if($user->hasRole('operator')){
                $model = WisataKunjungan::where('tipe_kunjungan', $tipe)->whereHas('wisata', function ($query) use ($request) {
                    $query->where('tipe_wisata', 'obyek')->whereNull('deleted_at');
                })
                ->where('wisata_id', $user->pengelola[0]->wisata_id)
                ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }else{
                $model = WisataKunjungan::where('tipe_kunjungan', $tipe)->whereHas('wisata', function ($query) use ($request) {
                    $query->where('tipe_wisata', 'obyek')->whereNull('deleted_at');
                })
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
        $data['page_name'] = "Kunjungan Obyek Wisata ".ucwords($tipe);
        $data['page_description'] = "Buat kunjungan obyek wisata baru";
        $data['data'] = new WisataKunjungan;
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
            'tanggal'           => 'required|string',
            'jumlah_wisatawan'  => 'required|integer',
            'keterangan'        => 'required|string',
            'url_foto.*'        => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
        ]);

        // // upload foto
        // $gambar = $request->file('foto');
        // $gambarName = str_replace(" ","_",$request->input('tanggal')).time().'.'.$gambar->getClientOriginalExtension();
        // $gambar->move(public_path("/uploads/kunjungan/obyek_wisata/"), $gambarName);
        // $request->request->add([
        //     'file'     => 'uploads/kunjungan/obyek_wisata/'.$gambarName
        // ]);
        
        $kunjunganWisata = new WisataKunjungan;
        $kunjunganWisata->tanggal = $request->tanggal;
        $kunjunganWisata->jumlah_wisatawan = $request->jumlah_wisatawan;
        $kunjunganWisata->keterangan = $request->keterangan;
        $user = \Auth::user();
        if($user->hasRole('superadmin')){
            $wisata = Wisata::where('tipe_wisata', 'obyek')->findOrFail($request->obyek_wisata);
        }else{
            $wisata = Wisata::where('tipe_wisata', 'obyek')->findOrFail($user->pengelola[0]->wisata_id);
        }
        $kunjunganWisata->wisata()->associate($wisata);
        // $kunjunganWisata->foto = $request->file;
        $kunjunganWisata->foto = 'uploads/default.jpg';
        $kunjunganWisata->tipe_kunjungan = $tipe;
        $kunjunganWisata->save();

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
                
                $judul = strtolower(str_replace(" ","_",$request->input('tanggal')).time());

                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    // $gambarName = str_replace(" ","_",$request->input('judul')).time().'.'.$gambar->getClientOriginalExtension();
                    $gambarName = time().str_replace(" ","_",$gambar->getClientOriginalName());
                    $gambar->move(public_path("/uploads/kunjungan/obyek_wisata/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/kunjungan/obyek_wisata/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/kunjungan/obyek_wisata/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new WisataKunjunganFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->wisataKunjungan()->associate($kunjunganWisata);
        
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
        $data = WisataKunjungan::findOrFail($id);

        $parse['page_name'] = "Ubah Kunjungan Obyek Wisata ".ucwords($tipe);
        $parse['page_description'] = "Ubah Kunjungan Obyek Wisata ".ucwords($tipe);
        $parse['data'] = $data;
        $parse['tipe_wisata'] = $tipe;
        $parse['fotos'] = WisataKunjunganFoto::where('wisata_kunjungan_id', $id)->get();

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
            'tanggal'           => 'required|string',
            'jumlah_wisatawan'  => 'required|integer',
            'keterangan'        => 'required|string'
        ]);

        // // upload gambar
        // $gambar = $request->file('foto');
        // if(!empty($gambar)){
        //     $this->validate($request, [
        //         'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ]);

        //     $gambarName = str_replace(" ","_",$request->input('tanggal')).time().'.'.$gambar->getClientOriginalExtension();
        //     $gambar->move(public_path("/uploads/kunjungan/obyek_wisata/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/kunjungan/obyek_wisata/'.$gambarName
        //     ]);
        // }

        $user = \Auth::user();
        if($user->hasRole('superadmin')){
            $wisata = Wisata::where('tipe_wisata', 'obyek')->findOrFail($request->obyek_wisata);
        }else{
            $wisata = Wisata::where('tipe_wisata', 'obyek')->findOrFail($user->pengelola[0]->wisata_id);
        }

        $kunjunganWisata = WisataKunjungan::findOrFail($id);
        $kunjunganWisata->tanggal = $request->tanggal;
        $kunjunganWisata->jumlah_wisatawan = $request->jumlah_wisatawan;
        $kunjunganWisata->keterangan = $request->keterangan;
        $kunjunganWisata->wisata()->associate($wisata);
        // cover ga dipake
        if(!empty($request->file)){
            $kunjunganWisata->foto = $request->file;
        }

        // delete foto yg sebelumnya
        $delFoto = WisataKunjunganFoto::where('wisata_kunjungan_id',$id)->get();
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
                    $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
    
                    $gambar->move(public_path("/uploads/kunjungan/obyek_wisata/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/kunjungan/obyek_wisata/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/kunjungan/obyek_wisata/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new WisataKunjunganFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->wisataKunjungan()->associate($kunjunganWisata);
        
                $ft->save();
            }
        }

        $kunjunganWisata->save();

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
        $data = WisataKunjungan::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di hapus.");
    }
}