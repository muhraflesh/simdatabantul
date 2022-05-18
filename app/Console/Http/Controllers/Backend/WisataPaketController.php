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
use App\WisataPaket;
use App\Wisata;

class WisataPaketController extends Controller{

    public $routePath = "backend::wisata_paket";
    public $prefix = "backend.wisata_paket";

    public function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.wisata_paket';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Paket Wisata";
        $data['page_description'] = "Paket Wisata";

        $user = Auth::user();

        if(!empty($request->nama)){
            $model = WisataPaket::where('nama', 'like', '%'.$request->nama.'%')
            ->where('wisata_id', $user->pengelola[0]->wisata_id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = WisataPaket::whereNull('deleted_at')
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
        $data['page_name'] = "Buat Paket Wisata";
        $data['page_description'] = "Buat paket wisata baru";

        $data['data'] = new WisataPaket;

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
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer',
            'keterangan' => 'required|string'
        ]);

        $wisata = Wisata::findOrFail(Auth::user()->pengelola[0]->wisata_id);

        $wisataPaket = new WisataPaket;
        $wisataPaket->nama = $request->nama;
        $wisataPaket->harga = $request->harga;
        $wisataPaket->keterangan = $request->keterangan;
        $wisataPaket->wisata()->associate($wisata);
        $wisataPaket->save();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = WisataPaket::findOrFail($id);

        $parse['page_name'] = "Ubah Wisata Paket";
        $parse['page_description'] = "Ubah Wisata Paket";
        $parse['data'] = $data;

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
            'harga' => 'required|integer',
            'keterangan' => 'required|string'
        ]);

        $wisataPaket = WisataPaket::findOrFail($id);
        $wisataPaket->nama = $request->nama;
        $wisataPaket->harga = $request->harga;
        $wisataPaket->keterangan = $request->keterangan;
        $wisataPaket->save();

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
        $data = WisataPaket::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
}