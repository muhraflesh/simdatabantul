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
use App\HotelPaketWisata;
use App\Hotel;

class HotelPaketWisataController extends Controller{

    public $routePath = "backend::hotel_paket_wisata";
    public $prefix = "backend.hotel_paket_wisata";

    public function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.hotel_paket_wisata';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Hotel Paket Wisata";
        $data['page_description'] = "Hotel Paket Wisata";

        $user = Auth::user();

        if(!empty($request->nama)){
            $model = HotelPaketWisata::where('nama', 'like', '%'.$request->nama.'%')
            ->where('hotel_id', $user->hotel->id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = HotelPaketWisata::whereNull('deleted_at')
            ->where('hotel_id', $user->hotel->id)
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
        $data['page_name'] = "Buat Paket Wisata Hotel";
        $data['page_description'] = "Buat paket wisata baru";

        $data['data'] = new HotelPaketWisata;

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

        $hotel = Hotel::findOrFail(Auth::user()->hotel->id);

        $wisataPaket = new HotelPaketWisata;
        $wisataPaket->nama = $request->nama;
        $wisataPaket->harga = $request->harga;
        $wisataPaket->keterangan = $request->keterangan;
        $wisataPaket->hotel()->associate($hotel);
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
        $data = HotelPaketWisata::findOrFail($id);

        $parse['page_name'] = "Ubah Hotel Wisata Paket";
        $parse['page_description'] = "Ubah Hotel Wisata Paket";
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

        $wisataPaket = HotelPaketWisata::findOrFail($id);
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
        $data = HotelPaketWisata::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
}