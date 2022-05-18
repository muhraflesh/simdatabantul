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
use App\HotelFasilitas;
use App\HotelFasilitasFoto;
use App\Hotel;

class HotelFasilitasController extends Controller{

    public $routePath = "backend::hotel_fasilitas";
    public $prefix = "backend.hotel_fasilitas";

    public function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.hotel_fasilitas';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Fasilitas Umum";
        $data['page_description'] = "Fasilitas umum hotel";

        $user = Auth::user();
        if(!empty($request->nama)){
            $model = HotelFasilitas::where('nama', 'like', '%'.$request->nama.'%')
            ->where('hotel_id', $user->hotel->id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = HotelFasilitas::whereNull('deleted_at')
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
        $data['page_name'] = "Buat Fasilitas";
        $data['page_description'] = "Buat fasilitas baru";

        $data['data'] = new HotelFasilitas;

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

        $hotel = Hotel::findOrFail(Auth::user()->hotel->id);

        $hotelFasilitas = new HotelFasilitas;
        $hotelFasilitas->nama = $request->nama;
        $hotelFasilitas->jumlah = $request->jumlah;
        $hotelFasilitas->keterangan = $request->keterangan;
        // $hotelFasilitas->foto = $request->file;
        $hotelFasilitas->foto = 'uploads/default.jpg';
        $hotelFasilitas->hotel()->associate($hotel);
        $hotelFasilitas->save();

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
                
                $judul = strtolower(str_replace(" ","_",$request->input('nama')).time());

                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    // $gambarName = str_replace(" ","_",$request->input('judul')).time().'.'.$gambar->getClientOriginalExtension();
                    $gambarName = time().str_replace(" ","_",$gambar->getClientOriginalName());
                    $gambar->move(public_path("/uploads/hotel_fasilitas/".$judul."/"), $gambarName);

                    $image_path = app_path("uploads/hotel_fasilitas/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/hotel_fasilitas/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }

                $ft = new HotelFasilitasFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->fasilitas()->associate($hotelFasilitas);
        
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
        $data = HotelFasilitas::findOrFail($id);

        $parse['page_name'] = "Ubah Fasilitas Umum";
        $parse['page_description'] = "Ubah Fasilitas Umum";
        $parse['data'] = $data;
        $parse['fotos'] = HotelFasilitasFoto::where('hotel_fasilitas_id', $id)->get();

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
        //     $gambar->move(public_path("/uploads/hotel_fasilitas/"), $gambarName);
        //     $request->request->add([
        //         'file'     => 'uploads/hotel_fasilitas/'.$gambarName
        //     ]);
        // }

        $hotelFasilitas = HotelFasilitas::findOrFail($id);
        $hotelFasilitas->nama = $request->nama;
        $hotelFasilitas->jumlah = $request->jumlah;
        $hotelFasilitas->keterangan = $request->keterangan;
        // cover ga dipake
        if(!empty($request->file)){
            $hotelFasilitas->foto = $request->file;
        }

        // delete foto yg sebelumnya
        $delFoto = HotelFasilitasFoto::where('hotel_fasilitas_id',$id)->get();
        foreach($delFoto as $df){
            $df->forceDelete();
        }

        // upload foto
        if(!empty($request->foto)){
            foreach($request->foto as $foto){
            
                $judul = strtolower(str_replace(" ","_",$request->input('nama')).time());
    
                if(!empty($foto['url_foto'])){
                    $gambar = $foto['url_foto'];
                    $gambarName = str_replace(" ","_",$request->input('nama')).time().'.'.$gambar->getClientOriginalExtension();
    
                    $gambar->move(public_path("/uploads/hotel_fasilitas/".$judul."/"), $gambarName);
    
                    $image_path = app_path("uploads/hotel_fasilitas/".$judul."/".$foto['url_foto']);
                    $filename = 'uploads/hotel_fasilitas/'.$judul.'/'.$gambarName;
                }else{
                    $filename = $foto['backup_url'];
                }
    
                $ft = new HotelFasilitasFoto;
                $ft->nama_foto = $foto['nama_foto'];
                $ft->url_foto = $filename;
                $ft->fasilitas()->associate($hotelFasilitas);
        
                $ft->save();
            }
        }

        $hotelFasilitas->save();

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
        $data = HotelFasilitas::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
}