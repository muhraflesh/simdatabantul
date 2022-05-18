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
use App\Hotel;
use App\HotelKamar;
use App\HotelMenginap;

class HotelController extends Controller{

    public $routePath = "backend::menginap_hotel";
    public $prefix = "backend.menginap_hotel";

    function __construct(){
        $this->prefix = 'backend.menginap_hotel';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $tipe){
        $data['page_name'] = "Menginap Hotel ".ucwords($tipe);
        $data['page_description'] = "Data Menginap Hotel ".ucwords($tipe);

        $user = \Auth::user();

        if(!empty($request->cari)){
            if($user->hasRole('operator_hotel')){
                $model = HotelMenginap::where('tipe_menginap', $tipe)
                ->whereHas('kamar', function ($query) use ($request, $user) {
                    $query->whereHas('hotel', function($q) use ($request, $user){
                        $q->where('user_id', $user->id);
                        $q->where('nama_hotel', 'like', '%'.$request->nama.'%');
                        if(!empty($request->jenis)){
                            $q->where('jenis_hotel', $request->jenis);
                        }
                    })->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }else{
                
                $model = HotelMenginap::where('tipe_menginap', $tipe)
                ->whereHas('kamar', function ($query) use ($request) {
                    $query->whereHas('hotel', function($q) use ($request){
                        $q->where('nama_hotel', 'like', '%'.$request->nama.'%');
                        
                        if(!empty($request->jenis)){
                            $q->where('jenis_hotel', $request->jenis);
                        }
                    });
                    $query->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')
                ->paginate(10);
            }
        }else{
            if($user->hasRole('operator_hotel')){
                $model = HotelMenginap::where('tipe_menginap', $tipe)
                ->whereHas('kamar', function ($query) use ($request, $user) {
                    $query->whereHas('hotel', function($q) use ($user){
                        $q->where('user_id', $user->id);
                    });
                    $query->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
            }else{
                $model = HotelMenginap::where('tipe_menginap', $tipe)
                ->whereHas('kamar', function ($query) use ($request) {
                    $query->whereHas('hotel', function($q){
                        $q->whereNull('deleted_at');
                    });
                    $query->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'asc')->paginate(10);
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
        $data['page_name'] = "Penginapan Hotel ".ucwords($tipe);
        $data['page_description'] = "Menginap hotel baru";
        $data['data'] = new HotelMenginap;
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
            'kamar' => 'required',
            'tanggal' => 'required|string',
            'total' => 'required|integer',
            'lama_menginap'     => 'required|integer'
        ]);

        $kamar = HotelKamar::findOrFail($request->kamar);

        $hotelMenginap = new HotelMenginap;
        $hotelMenginap->tanggal = $request->tanggal;
        $hotelMenginap->lama_menginap = $request->lama_menginap;
        $hotelMenginap->jumlah_menginap = $request->jumlah_menginap;
        $hotelMenginap->tipe_menginap = $tipe;
        $hotelMenginap->harga_perkamar = $kamar->harga_permalam;
        $hotelMenginap->total = $kamar->harga_permalam*$request->lama_menginap;
        $hotelMenginap->kamar()->associate($kamar);
        $hotelMenginap->save();

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $tipe, $id){
        $data = HotelMenginap::findOrFail($id);

        $parse['page_name'] = "Ubah Penginapan Hotel ".ucwords($tipe);
        $parse['page_description'] = "Ubah Penginapan Hotel ".ucwords($tipe);
        $parse['data'] = $data;
        $parse['tipe_wisata'] = $tipe;

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
            'kamar' => 'required',
            'tanggal' => 'required|string',
            'total' => 'required|integer',
            'lama_menginap'     => 'required|integer'
        ]);

        $kamar = HotelKamar::findOrFail($request->kamar);

        $hotelMenginap = HotelMenginap::findOrFail($id);
        $hotelMenginap->tanggal = $request->tanggal;
        $hotelMenginap->lama_menginap = $request->lama_menginap;
        $hotelMenginap->jumlah_menginap = $request->jumlah_menginap;
        $hotelMenginap->tipe_menginap = $tipe;
        $hotelMenginap->harga_perkamar = $kamar->harga_permalam;
        $hotelMenginap->total = $kamar->harga_permalam*$request->lama_menginap;
        $hotelMenginap->kamar()->associate($kamar);
        $hotelMenginap->save();

        return redirect()->route($this->routePath. ".index", $tipe)->with('success', "Data berhasil di ubah.");
    }

    /**
     * Delete the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, $id, Request $request){
        $data = HotelMenginap::findOrFail($id);
        $data->delete();
        
        return redirect()->route($this->routePath. ".index", ['tipe'=>$type])->with('success', "Data berhasil di hapus.");
    }
}