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
use App\Akomodasi;
use App\AkomodasiKategori;
use App\Wisata;

class AkomodasiController extends Controller{

    public $routePath = "backend::master.akomodasi";
    public $prefix = "backend.master.akomodasi";

    function __construct(){
        $this->prefix = 'backend.master.akomodasi';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Homestay";
        $data['page_description'] = "Master data Homestay";

        $user = \Auth::user();

        if($user->hasRole('operator')){
            if (\Auth::user()->pengelola[0]->wisata->tipe_wisata!='desa') {
                return redirect()->route('backend::dashboard')->with('warning', "Anda tidak memiliki akses kelola desa wisata.");
            }
        }

        if(!empty($request->nama)){
            if($user->hasRole('operator')){
                $model = Akomodasi::
                where('nama_pemilik', 'like', '%'.$request->nama.'%')
                // ->whereHas('wisata', function ($query) use ($request) {
                //     $query->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'desa')->whereNull('deleted_at');
                // })
                ->where('wisata_id', $user->pengelola[0]->wisata_id)
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }else{
                $model = Akomodasi::
                where('nama_pemilik', 'like', '%'.$request->nama.'%')
                // ->whereHas('wisata', function ($query) use ($request) {
                //     $query->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'desa')->whereNull('deleted_at');
                // })
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }
        }else{
            if($user->hasRole('operator')){
                $model = Akomodasi::whereHas('wisata', function ($query) use ($request) {
                    $query->where('tipe_wisata', 'desa')->whereNull('deleted_at');
                })
                ->where('wisata_id', $user->pengelola[0]->wisata_id)
                ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }else{
                $model = Akomodasi::whereHas('wisata', function ($query) use ($request) {
                    $query->where('tipe_wisata', 'desa')->whereNull('deleted_at');
                })->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }
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
        $data['page_name'] = "Homestay";
        $data['page_description'] = "Buat homestay baru";
        $data['data'] = new Akomodasi;
        $user = \Auth::user();
        if($user->hasRole('operator')){
            if (\Auth::user()->pengelola[0]->wisata->tipe_wisata!='desa') {
                return redirect()->route('backend::dashboard')->with('warning', "Anda tidak memiliki akses kelola desa wisata.");
            }
        }

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
            'nama_akomodasi' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'alamat'     => 'required|string',
            'kontak'     => 'required',
            'jumlah_kamar'     => 'required|integer',
            'harga_kamar'     => 'required|integer',
            'kategori'    => 'required'
        ]);
        $user = \Auth::user();

        if($user->hasRole('superadmin')){
            $this->validate($request, [
                'desa_wisata'     => 'required'
            ]);
        }

        $kategori = AkomodasiKategori::findOrFail($request->kategori);
    
        if($user->hasRole('superadmin')){
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($request->desa_wisata);
        }else{
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($user->pengelola[0]->wisata_id);
        }
        
        $akomodasi = new Akomodasi;
        $akomodasi->nama_akomodasi = $request->nama_akomodasi;
        $akomodasi->nama_pemilik = $request->nama_pemilik;
        $akomodasi->alamat = $request->alamat;
        $akomodasi->kontak = $request->kontak;
        $akomodasi->jumlah_kamar = $request->jumlah_kamar;
        $akomodasi->harga_kamar = $request->harga_kamar;
        $akomodasi->kategori()->associate($kategori);
        $akomodasi->wisata()->associate($wisata);
        $akomodasi->save();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = Akomodasi::findOrFail($id);

        $parse['page_name'] = "Ubah Homestay";
        $parse['page_description'] = "Ubah Homestay";
        $parse['data'] = $data;
        $user = \Auth::user();
        if($user->hasRole('operator')){
            if (\Auth::user()->pengelola[0]->wisata->tipe_wisata!='desa') {
                return redirect()->route('backend::dashboard')->with('warning', "Anda tidak memiliki akses kelola desa wisata.");
            }
        }

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
            'nama_akomodasi' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'alamat'     => 'required|string',
            'kontak'     => 'required',
            'jumlah_kamar'     => 'required|integer',
            'harga_kamar'     => 'required|integer',
            'kategori'    => 'required'
        ]);

        $user = \Auth::user();
        if($user->hasRole('superadmin')){
            $this->validate($request, [
                'desa_wisata'     => 'required'
            ]);
        }

        $kategori = AkomodasiKategori::findOrFail($request->kategori);
        if($user->hasRole('superadmin')){
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($request->desa_wisata);
        }else{
            $wisata = Wisata::where('tipe_wisata', 'desa')->findOrFail($user->pengelola[0]->wisata_id);
        }
        
        $akomodasi = Akomodasi::findOrFail($id);
        $akomodasi->nama_akomodasi = $request->nama_akomodasi;
        $akomodasi->nama_pemilik = $request->nama_pemilik;
        $akomodasi->alamat = $request->alamat;
        $akomodasi->kontak = $request->kontak;
        $akomodasi->jumlah_kamar = $request->jumlah_kamar;
        $akomodasi->harga_kamar = $request->harga_kamar;
        $akomodasi->kategori()->associate($kategori);
        $akomodasi->wisata()->associate($wisata);
        $akomodasi->save();

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
        $data = Akomodasi::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
}