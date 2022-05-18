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
use App\FasilitasUmum;
use App\FasilitasUmumFoto;
use App\Wisata;

class FasilitasUmumController extends Controller{

    public $routePath = "backend::fasilitas_umum";
    public $prefix = "backend.fasilitas_umum";

    public function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.fasilitas_umum';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Fasilitas Umum";
        $data['page_description'] = "Fasilitas umum wisata";

        $user = Auth::user();
        if(!empty($request->nama)){
            $model = FasilitasUmum::where('nama', 'like', '%'.$request->nama.'%')
            ->where('wisata_id', $user->pengelola[0]->wisata_id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = FasilitasUmum::whereNull('deleted_at')
            ->where('wisata_id', $user->pengelola[0]->wisata_id)
            ->orderBy('created_at', 'asc')->paginate(10);
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
        $data['page_name'] = "Buat Fasilitas Umum";
        $data['page_description'] = "Buat fasilitas umum baru";

        $data['data'] = new FasilitasUmum;

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
            'jumlah'        => 'required|numeric',
            'keterangan'    => 'required|string',
            'url_foto.*'    => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
        ]);

        // // upload gambar
        // $gambar = $request->file('foto');
        // if(!empty($gambar)){
        //     $this->validate($request, [
        //         'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ]);

        //     $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
        //     $gambar->move(public_path("/uploads/fasilitas_umum/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/fasilitas_umum/'.$gambarName
        //     ]);
        // }

        $wisata = Wisata::findOrFail(Auth::user()->pengelola[0]->wisata_id);

        $fasilitasUmum = new FasilitasUmum;
        $fasilitasUmum->nama = $request->nama;
        $fasilitasUmum->jumlah = $request->jumlah;
        $fasilitasUmum->keterangan = $request->keterangan;
        // $fasilitasUmum->foto = $request->file;
        $fasilitasUmum->foto = 'uploads/default.jpg';
        $fasilitasUmum->wisata()->associate($wisata);
        $fasilitasUmum->save();

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
                
                $judul = strtolower(str_replace(" ","_",$request->input('nama')).time());

                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    // $gambarName = str_replace(" ","_",$request->input('judul')).time().'.'.$gambar->getClientOriginalExtension();
                    $gambarName = time().str_replace(" ","_",$gambar->getClientOriginalName());
                    $gambar->move(public_path("/uploads/fasilitas_umum/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/fasilitas_umum/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/fasilitas_umum/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new FasilitasUmumFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->fasilitasUmum()->associate($fasilitasUmum);
        
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
        $data = FasilitasUmum::findOrFail($id);

        $parse['page_name'] = "Ubah Fasilitas Umum";
        $parse['page_description'] = "Ubah Fasilitas Umum";
        $parse['data'] = $data;
        $parse['fotos'] = FasilitasUmumFoto::where('fasilitas_umum_id', $id)->get();

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
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string'
        ]);

        // // upload gambar
        // $gambar = $request->file('foto');
        // if(!empty($gambar)){
        //     $this->validate($request, [
        //         'foto'    => 'required|image|mimes:jpeg,png,jpg|max:2048'
        //     ]);

        //     $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
        //     $gambar->move(public_path("/uploads/fasilitas_umum/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/fasilitas_umum/'.$gambarName
        //     ]);
        // }

        $fasilitasUmum = FasilitasUmum::findOrFail($id);
        $fasilitasUmum->nama = $request->nama;
        $fasilitasUmum->jumlah = $request->jumlah;
        $fasilitasUmum->keterangan = $request->keterangan;
        // cover ga dipake
        if(!empty($request->file)){
            $fasilitasUmum->foto = $request->file;
        }

        // delete foto yg sebelumnya
        $delFoto = FasilitasUmumFoto::where('fasilitas_umum_id',$id)->get();
        foreach($delFoto as $df){
            $df->forceDelete();
        }

        // upload foto
        if(!empty($request->foto)){
            $this->validate($request, [
                'url_foto.*'    => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
            ]);

            foreach($request->foto as $foto){
            
                $judul = strtolower(str_replace(" ","_",$request->input('nama')).time());
    
                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
    
                    $gambar->move(public_path("/uploads/fasilitas_umum/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/fasilitas_umum/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/fasilitas_umum/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new FasilitasUmumFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->fasilitasUmum()->associate($fasilitasUmum);
        
                $ft->save();
            }
        }

        $fasilitasUmum->save();

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
        $data = FasilitasUmum::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
}