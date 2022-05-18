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
use App\Hotel;
use App\HotelKamar;

class JenisKamarController extends Controller{

    public $routePath = "backend::master.jenis_kamar";
    public $prefix = "backend.master.jenis_kamar";

    function __construct(){
        $this->prefix = 'backend.master.jenis_kamar';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Jenis Kamar Hotel";
        $data['page_description'] = "Data Jenis Kamar Hotel";

        $user = \Auth::user();
        
        if(!empty($request->nama)){
            $model = HotelKamar::
            where('jenis_kamar', 'like', '%'.$request->nama.'%')
            ->whereHas('hotel', function ($query) use ($request, $user) {
                $query->where('user_id', $user->id)->whereNull('deleted_at');
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = HotelKamar::whereNull('deleted_at')
            ->whereHas('hotel', function ($query) use ($request, $user) {
                $query->where('user_id', $user->id)->whereNull('deleted_at');
            })->orderBy('created_at', 'asc')->paginate(10);
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
        $data['page_name'] = "Jenis Kamar Hotel";
        $data['page_description'] = "Buat jenis kamar hotel baru";
        $data['data'] = new HotelKamar;

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
            'jenis_kamar' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan'     => 'required|string'
        ]);

        $user = \Auth::user();

        $hotel = Hotel::where('user_id', $user->id)->firstOrFail();

        $hotelKamar = new HotelKamar;
        $hotelKamar->jenis_kamar = $request->jenis_kamar;
        $hotelKamar->harga_permalam = $request->harga;
        $hotelKamar->keterangan = $request->keterangan;
        $hotelKamar->hotel()->associate($hotel);

        $hotelKamar->save();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id){
        $data = HotelKamar::findOrFail($id);

        $parse['page_name'] = "Ubah Jenis Kamar Hotel";
        $parse['page_description'] = "Ubah Jenis Kamar Hotel";
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
            'jenis_kamar' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'keterangan'     => 'required|string'
        ]);

        // hotel
        $hotelKamar = HotelKamar::findOrFail($id);
        $hotelKamar->jenis_kamar = $request->jenis_kamar;
        $hotelKamar->harga_permalam = $request->harga;
        $hotelKamar->keterangan = $request->keterangan;
        $hotelKamar->save();

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
        $user = \Auth::user();

        $data = HotelKamar::whereHas('hotel', function ($query) use ($request, $user) {
            $query->where('user_id', $user->id)->whereNull('deleted_at');
        })->findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }

}