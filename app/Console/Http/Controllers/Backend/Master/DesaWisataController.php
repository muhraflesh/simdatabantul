<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-26 10:28:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Wisata;
use App\WisataFoto;
use App\Kecamatan;
use App\Kelurahan;

class DesaWisataController extends Controller{

    public $routePath = "backend::master.desa_wisata";
    public $prefix = "backend.master.desa_wisata";

    function __construct(){
        $this->prefix = 'backend.master.desa_wisata';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Desa Wisata";
        $data['page_description'] = "Master data Desa Wisata";

        if(!empty($request->nama)){
            $model = Wisata::where('tipe_wisata', 'desa')
            ->where('nama', 'like', '%'.$request->nama.'%')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = Wisata::where('tipe_wisata', 'desa')->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
        }

        $data['data'] = $model;

        return view($this->prefix.'.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data['page_name'] = "Desa Wisata";
        $data['page_description'] = "Buat desa wisata baru";
        $data['data'] = new Wisata;

        return view($this->prefix.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // validasi form
        $this->validate($request, [
            'nama'          => 'required|string|max:255',
            'alamat'        => 'required|string',
            'jam_buka'      => 'required',
            'kelurahan'     => 'required',
            'kecamatan'     => 'required',
            'url_foto.*'    => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
        ]);

        // // upload foto
        // $gambar = $request->file('foto');
        // $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
        // $gambar->move(public_path("/uploads/desa_wisata/"), $gambarName);
        // $request->request->add([
        //     'file'     => 'uploads/desa_wisata/'.$gambarName
        // ]);
        
        $desaWisata = new Wisata;
        $desaWisata->nama = $request->nama;
        $desaWisata->alamat = $request->alamat;
        $desaWisata->jam_buka = $request->jam_buka;
        $kelurahan = Kelurahan::findOrFail($request->kelurahan);
        $desaWisata->kelurahan()->associate($kelurahan);
        // $desaWisata->foto = $request->file;
        $desaWisata->foto = 'uploads/default.jpg';
        $desaWisata->tipe_wisata = 'desa';
        $desaWisata->save();

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
                
                $judul = strtolower(str_replace(" ","_",$request->input('tanggal')).time());

                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    // $gambarName = str_replace(" ","_",$request->input('judul')).time().'.'.$gambar->getClientOriginalExtension();
                    $gambarName = time().str_replace(" ","_",$gambar->getClientOriginalName());
                    $gambar->move(public_path("/uploads/desa_wisata/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/desa_wisata/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/desa_wisata/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new WisataFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->wisata()->associate($desaWisata);
        
                $ft->save();
            }
        }

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = Wisata::findOrFail($id);

        $parse['page_name'] = "Ubah Desa Wisata";
        $parse['page_description'] = "Ubah Desa Wisata";
        $parse['data'] = $data;
        $parse['fotos'] = WisataFoto::where('wisata_id', $id)->get();

        return view($this->prefix.'.edit', $parse);
    }

    /**
     * Update the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request){
        // validasi form
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'alamat'     => 'required|string',
            'jam_buka'     => 'required',
            'kelurahan'     => 'required',
            'kecamatan'     => 'required'
        ]);

        // // upload gambar
        // $gambar = $request->file('foto');
        // if(!empty($gambar)){
        //     $this->validate($request, [
        //         'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ]);

        //     $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
        //     $gambar->move(public_path("/uploads/desa_wisata/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/desa_wisata/'.$gambarName
        //     ]);
        // }

        $kelurahan = Kelurahan::findOrFail($request->kelurahan);

        $desaWisata = Wisata::findOrFail($id);
        $desaWisata->nama = $request->nama;
        $desaWisata->alamat = $request->alamat;
        $desaWisata->jam_buka = $request->jam_buka;
        $desaWisata->kelurahan()->associate($kelurahan);
        // cover ga dipake
        if(!empty($request->file)){
            $desaWisata->foto = $request->file;
        }

        // delete foto yg sebelumnya
        $delFoto = WisataFoto::where('wisata_id',$id)->get();
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
    
                    $gambar->move(public_path("/uploads/desa_wisata/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/desa_wisata/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/desa_wisata/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new WisataFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->wisata()->associate($desaWisata);
        
                $ft->save();
            }
        }

        $desaWisata->save();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di ubah.");
    }

    /**
     * Delete the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request){
        $data = Wisata::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
}