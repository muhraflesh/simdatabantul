<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-26 10:28:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\Wisata;
use App\Pengelola;

class PenggunaController extends Controller{

    public $routePath = "backend::pengguna";
    public $prefix = "backend.pengguna";

    function __construct(){
        $this->themeBack = config('larakuy.theme_back');
        
        $this->prefix = 'backend.pengguna';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Pengguna";
        $data['page_description'] = "Menejemen pengguna";

        if(!empty($request->nama)){
            $model = User::where('id', '!=', \Auth::user()->id)->where('name', 'like', '%'.$request->nama.'%')
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = User::where('id', '!=', \Auth::user()->id)->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
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
        $data['page_name'] = "Buat Pengguna";
        $data['page_description'] = "Buat pengguna baru";

        $data['data'] = new User;
        $data['role'] = Role::get();
        $data['tipe'] = \Request::get('tipe');

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = User::findOrFail($id);

        $parse['page_name'] = "Ubah Pengguna";
        $parse['page_description'] = "Ubah pengguna";
        $parse['data'] = $data;
        $parse['role'] = Role::get();

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

    /**
     * Update the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Delete the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request){
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->route($this->routePath. ".index")->with('success', "Data berhasil di hapus.");
    }
    
    public function bukablokir($id, Request $request){
        $user = User::findOrFail($id);
        $user->login_counter = 0;
        $user->save();

        return redirect()->route($this->routePath. ".index")->with('success', "User berhasil dibuka status blokirnya.");
    }
}