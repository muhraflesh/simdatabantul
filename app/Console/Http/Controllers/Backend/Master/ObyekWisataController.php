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

class ObyekWisataController extends Controller{

    public $routePath = "backend::master.obyek_wisata";
    public $prefix = "backend.master.obyek_wisata";

    function __construct(){
        $this->prefix = 'backend.master.obyek_wisata';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Obyek Wisata";
        $data['page_description'] = "Master data Obyek Wisata";

        if(!empty($request->nama)){
            $model = Wisata::where('tipe_wisata', 'obyek')
            ->where('nama', 'like', '%'.$request->nama.'%')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = Wisata::where('tipe_wisata', 'obyek')->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
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
        $data['page_name'] = "Obyek Wisata";
        $data['page_description'] = "Buat obyek wisata baru";
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

        // dd($request->all());
        
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
        // $gambar->move(public_path("/uploads/obyek_wisata/"), $gambarName);
        // $request->request->add([
        //     'file'     => 'uploads/obyek_wisata/'.$gambarName
        // ]);
        
        $obyekWisata = new Wisata;
        $obyekWisata->nama = $request->nama;
        $obyekWisata->alamat = $request->alamat;
        $obyekWisata->jam_buka = $request->jam_buka;
        $kelurahan = Kelurahan::findOrFail($request->kelurahan);
        $obyekWisata->kelurahan()->associate($kelurahan);
        // $obyekWisata->foto = $request->file;
        $obyekWisata->foto = 'uploads/default.jpg';
        $obyekWisata->tipe_wisata = 'obyek';
        $obyekWisata->save();

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
                
                $judul = strtolower(str_replace(" ","_",$request->input('tanggal')).time());

                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    // $gambarName = str_replace(" ","_",$request->input('judul')).time().'.'.$gambar->getClientOriginalExtension();
                    $gambarName = time().str_replace(" ","_",$gambar->getClientOriginalName());
                    $gambar->move(public_path("/uploads/obyek_wisata/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/obyek_wisata/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/obyek_wisata/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new WisataFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->wisata()->associate($obyekWisata);
        
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

        $parse['page_name'] = "Ubah Obyek Wisata";
        $parse['page_description'] = "Ubah Obyek Wisata";
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
            'nama'      => 'required|string|max:255',
            'alamat'    => 'required|string',
            'jam_buka'  => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required'
        ]);

        // // upload gambar
        // $gambar = $request->file('foto');
        // if(!empty($gambar)){
        //     $this->validate($request, [
        //         'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ]);

        //     $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
        //     $gambar->move(public_path("/uploads/obyek_wisata/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/obyek_wisata/'.$gambarName
        //     ]);
        // }

        $kelurahan = Kelurahan::findOrFail($request->kelurahan);

        $obyekWisata = Wisata::findOrFail($id);
        $obyekWisata->nama = $request->nama;
        $obyekWisata->alamat = $request->alamat;
        $obyekWisata->jam_buka = $request->jam_buka;
        $obyekWisata->kelurahan()->associate($kelurahan);
        // cover ga dipake
        if(!empty($request->file)){
            $obyekWisata->foto = $request->file;
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
    
                    $gambar->move(public_path("/uploads/obyek_wisata/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/obyek_wisata/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/obyek_wisata/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new WisataFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->wisata()->associate($obyekWisata);
        
                $ft->save();
            }
        }

        $obyekWisata->save();

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