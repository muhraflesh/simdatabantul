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
use App\User;
use App\Role;

class HotelController extends Controller{

    public $routePath = "backend::master.hotel";
    public $prefix = "backend.master.hotel";

    function __construct(){
        $this->prefix = 'backend.master.hotel';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Hotel";
        $data['page_description'] = "Master data Hotel";

        $user = \Auth::user();
        
        if(!empty($request->nama)){
            $model = Hotel::
            where('nama_pemilik', 'like', '%'.$request->nama.'%')
            // ->whereHas('wisata', function ($query) use ($request) {
            //     $query->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'desa')->whereNull('deleted_at');
            // })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = Hotel::whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
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
        $data['page_name'] = "Hotel";
        $data['page_description'] = "Buat hotel baru";
        $data['data'] = new Hotel;

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
            'nama_hotel' => 'required|string|max:255',
            'alamat'     => 'required|string',
            'jenis' => 'required',
            'nama' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users',
            'no_hp' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        // Pengguna
        $role = Role::where('name', 'operator_hotel')->firstOrFail();

        $user = new User;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->no_hp = $request->no_hp;
        $user->deskripsi = "";
        $user->status = true;
        $user->password = bcrypt($request->password);

        $user->save();
        $user->attachRole($role);

        $hotel = new Hotel;
        $hotel->nama_hotel = $request->nama_hotel;
        $hotel->alamat_hotel = $request->alamat;
        $hotel->kontak_hotel = $request->no_hp;
        $hotel->email_hotel = $request->email;
        $hotel->jenis_hotel = $request->jenis;
        $hotel->user()->associate($user);
        $hotel->save();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = Hotel::findOrFail($id);

        $parse['page_name'] = "Ubah Hotel";
        $parse['page_description'] = "Ubah Hotel";
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
            'nama_hotel' => 'required|string|max:255',
            'alamat'     => 'required|string',
            'jenis' => 'required',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|numeric'
        ]);

        if(!empty($request->password)){
            $this->validate($request, [
                'password' => 'string|min:6'
            ]);
        }

        // hotel
        $hotel = Hotel::findOrFail($id);
        $hotel->nama_hotel = $request->nama_hotel;
        $hotel->alamat_hotel = $request->alamat;
        $hotel->kontak_hotel = $request->no_hp;
        $hotel->jenis_hotel = $request->jenis;
        $hotel->save();
        
        // user
        $user = User::findOrFail($hotel->user_id);
        $user->name = $request->nama;
        $user->no_hp = $request->no_hp;
        
        if((!empty($request->password))){
            $user->password = bcrypt($request->password);
        }
        $user->save();

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
        $data = Hotel::findOrFail($id);
        $data->delete();

        $u = User::findOrFail($data->user_id);
        $u->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }

}