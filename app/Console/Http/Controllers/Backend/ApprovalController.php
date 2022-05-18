<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\Wisata;
use App\Pengelola;

class ApprovalController extends Controller{

    public $routePath = "backend::approval";
    public $prefix = "backend.approval";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.approval';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Approval";
        $data['page_description'] = "Approval Destinasi";

        if(!empty($request->nama)){
            $model = \App\Pengajuan::
            leftJoin('hotel', 'hotel.id', '=', 'pengajuan_destinasi.id_hotel')
            ->leftJoin('wisata', 'wisata.id', '=', 'pengajuan_destinasi.id_wisata')
            ->where('wisata.nama', 'like', '%'.$request->nama.'%')
            ->orWhere('hotel.nama_hotel', 'like', '%'.$request->nama.'%')
            ->orderBy('pengajuan_destinasi.created_at', 'asc')
            ->paginate(10);
        }else{
            $model = \App\Pengajuan::
            leftJoin('hotel', 'hotel.id', '=', 'pengajuan_destinasi.id_hotel')
            ->leftJoin('wisata', 'wisata.id', '=', 'pengajuan_destinasi.id_wisata')
            ->orderBy('pengajuan_destinasi.created_at', 'asc')
            ->paginate(10);
        }

        $data['data'] = $model;

        return view($this->prefix.'.list', $data);
    }

    public function store(Request $request){
        // validasi form
        $this->validate($request, [
            'username'  => 'required|string|max:255|unique:users',
            'nama' => 'required|string|max:255',
            // 'deskripsi' => 'required|string|min:10',
            'no_hp' => 'required|numeric',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $role = Role::findOrFail($request->role);

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

        if($role->name=='operator'){
            $this->validate($request, [
                'wisata'    => 'required'
            ]);

            $wisata = Wisata::findOrFail($request->wisata);

            $pengelola = new Pengelola;
            $pengelola->wisata()->associate($wisata);
            $pengelola->user()->associate($user);
            $pengelola->save();
        }

        $rute = $this->routePath. ".index";

        if($request->tipe_pengelola=='desa_wisata'){
            $rute = "backend::pengelola.desa_wisata.index";
        }elseif($request->tipe_pengelola=='obyek_wisata'){
            $rute = "backend::pengelola.obyek_wisata.index";
        }

        return redirect()->route($rute)->with('success', "Data berhasil di simpan.");
    }

    public function edit($id){
        $data = User::findOrFail($id);

        $parse['page_name'] = "Ubah Pengguna";
        $parse['page_description'] = "Ubah pengguna";
        $parse['data'] = $data;
        $parse['role'] = Role::get();

        return view($this->prefix.'.edit', $parse);
    }

    public function update($id, Request $request){
        // validasi form
        $this->validate($request, [
            // 'deskripsi' => 'required|string|min:10',
            'nama' => 'required|string|max:255'
        ]);

        if(!empty($request->password)){
            $this->validate($request, [
                'password' => 'string|min:6'
            ]);
        }
        
        // $role = Role::findOrFail($request->role);

        $user = User::findOrFail($id);
        $user->name = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->deskripsi = $request->deskripsi;
        
        if((!empty($request->password))){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // $user->roles()->sync([]); // Delete relationship data 
        // $user->attachRole($role); // add role

        if($user->hasRole('operator')){
            $this->validate($request, [
                'wisata'    => 'required'
            ]);

            $wisata = Wisata::findOrFail($request->wisata);

            // hapus pengelola
            $p = Pengelola::where('user_id', $id)->firstOrFail();
            $p->delete();

            // tambah lagi
            $pengelola = new Pengelola;
            $pengelola->wisata()->associate($wisata);
            $pengelola->user()->associate($user);
            $pengelola->save();
        }

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di ubah.");
    }

    public function active($id, Request $request){
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();

        // kirim email notif ke pengguna        
        $pesan = "Helo {$user->name}, akun anda telah dapat digunakan. Silahkan masuk dengan data yang sebelumnya pernah di daftarkan."; 

        // try{
        //     Mail::send('layouts.email', ['pesan' => $pesan], function ($message) use ($user)
        //     {
        //         $message->subject("Selamat! Akun anda telah aktif.");
        //         $message->from(config('larakuy.email_admin'), config('larakuy.email_name_admin'));
        //         $message->to($user->email);
        //     });
        //     // return back()->with('alert-success','Berhasil Kirim Email');
        // }
        // catch (Exception $e){
        //     dd($e->getMessage());
        //     return response (['status' => false,'errors' => $e->getMessage()]);
        // }

        return redirect()->route($this->routePath. ".index")->with('success', "Akun berhasil diaktifkan.");
    }

    public function destroy($id, Request $request){
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
}