<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-26 10:28:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Http\Controllers\Backend\Menginap;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Menginap;
use App\MenginapFoto;
use App\Akomodasi;
use App\Wisata;

class AkomodasiController extends Controller{

    public $routePath = "backend::menginap";
    public $prefix = "backend.menginap";

    function __construct(){
        $this->prefix = 'backend.menginap';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipe){
        $data['page_name'] = "Akomodasi Desa Wisata ".ucwords($tipe);
        $data['page_description'] = "Data Akomodasi Desa Wisata ".ucwords($tipe);

        $user = \Auth::user();

        if(!empty($request->nama)){
            if($user->hasRole('operator')){
                $model = Menginap::where('tipe_menginap', $tipe)
                ->whereHas('akomodasi', function ($query) use ($request, $user) {
                    $query->whereHas('wisata', function($q) use ($request){
                        $q->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'desa');
                    })->where('wisata_id', $user->pengelola[0]->wisata_id)->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }else{
                $model = Menginap::where('tipe_menginap', $tipe)
                ->whereHas('akomodasi', function ($query) use ($request) {
                    $query->whereHas('wisata', function($q) use ($request){
                        $q->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'desa');
                    })->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }
        }else{
            if($user->hasRole('operator')){
                $model = Menginap::where('tipe_menginap', $tipe)->whereHas('akomodasi', function ($query) use ($request, $user) {
                    $query->whereHas('wisata', function($q){
                        $q->where('tipe_wisata', 'desa');
                    })->where('wisata_id', $user->pengelola[0]->wisata_id)->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }else{
                $model = Menginap::where('tipe_menginap', $tipe)->whereHas('akomodasi', function ($query) use ($request) {
                    $query->whereHas('wisata', function($q){
                        $q->where('tipe_wisata', 'desa');
                    })->whereNull('deleted_at');
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
        $data['page_name'] = "Akomodasi Desa Wisata ".ucwords($tipe);
        $data['page_description'] = "Buat akomodasi desa wisata baru";
        $data['data'] = new Menginap;
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
            'akomodasi'             => 'required',
            'tanggal'               => 'required|string',
            'asal_kota_wisatawan'   => 'required|string',
            'lama_menginap'         => 'required|integer',
            'jumlah_menginap'       => 'required|integer',
            'url_foto.*'            => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
        ]);

        // upload foto
        // $gambar = $request->file('foto');
        // $gambarName = str_replace(" ","_",$request->input('tanggal')).time().'.'.$gambar->getClientOriginalExtension();
        // $gambar->move(public_path("/uploads/menginap/"), $gambarName);
        // $request->request->add([
        //     'file'     => 'uploads/menginap/'.$gambarName
        // ]);
        
        $akomodasi = Akomodasi::findOrFail($request->akomodasi);

        $menginapWisata = new Menginap;
        $menginapWisata->tanggal = $request->tanggal;
        $menginapWisata->asal_kota_wisatawan = $request->asal_kota_wisatawan;
        $menginapWisata->lama_menginap = $request->lama_menginap;
        $menginapWisata->jumlah_menginap = $request->jumlah_menginap;
        $menginapWisata->akomodasi()->associate($akomodasi);
        // $menginapWisata->foto = $request->file;
        $menginapWisata->foto = 'uploads/default.jpg';
        $menginapWisata->tipe_menginap = $tipe;
        $menginapWisata->save();

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
                
                $judul = strtolower(str_replace(" ","_",$request->judul));

                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    // $gambarName = str_replace(" ","_",$request->input('judul')).time().'.'.$gambar->getClientOriginalExtension();
                    $gambarName = time().str_replace(" ","_",$gambar->getClientOriginalName());
                    $gambar->move(public_path("/uploads/album/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/album/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/album/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new MenginapFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->menginap()->associate($menginapWisata);
        
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
        $data = Menginap::findOrFail($id);

        $parse['page_name'] = "Ubah Akomodasi Desa Wisata ".ucwords($tipe);
        $parse['page_description'] = "Ubah Akomodasi Desa Wisata ".ucwords($tipe);
        $parse['data'] = $data;
        $parse['tipe_wisata'] = $tipe;
        $parse['fotos'] = MenginapFoto::where('menginap_id', $id)->get();

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
            'akomodasi' => 'required',
            'tanggal' => 'required|string',
            'asal_kota_wisatawan' => 'required|string',
            'lama_menginap'     => 'required|integer',
            'jumlah_menginap'     => 'required|integer'
        ]);

        // upload gambar cover ga dipake
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

        $akomodasi = Akomodasi::findOrFail($request->akomodasi);

        $menginapWisata = Menginap::findOrFail($id);
        $menginapWisata->tanggal = $request->tanggal;
        $menginapWisata->asal_kota_wisatawan = $request->asal_kota_wisatawan;
        $menginapWisata->lama_menginap = $request->lama_menginap;
        $menginapWisata->jumlah_menginap = $request->jumlah_menginap;
        $menginapWisata->akomodasi()->associate($akomodasi);
        // cover ga dipake
        if(!empty($request->file)){
            $menginapWisata->foto = $request->file;
        }

        // delete foto yg sebelumnya
        $delFoto = MenginapFoto::where('menginap_id',$id)->get();
        foreach($delFoto as $df){
            $df->forceDelete();
        }

        // upload foto
        if(!empty($request->foto)){
            $this->validate($request, [
                'url_foto.*'    => 'mimes:jpeg,jpg,png,svg,gif|max:5048'
            ]);

            foreach($request->foto as $foto){
            
                $judul = strtolower(str_replace(" ","_",$request->judul));
    
                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    $gambarName = str_replace(" ","_",$request->input('nik')).time().'.'.$gambar->getClientOriginalExtension();
    
                    $gambar->move(public_path("/uploads/album/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/album/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/album/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new MenginapFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->menginap()->associate($menginapWisata);
        
                $ft->save();
            }
        }

        $menginapWisata->save();

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
        $data = Menginap::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di hapus.");
    }
}