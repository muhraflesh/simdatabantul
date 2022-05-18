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
use App\Wisata;
use App\Pengelola;
use App\Role;

class PengelolaController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Pengelola";
        $data['page_description'] = "Pengelola wisata";
        
        $user = Auth::user();
        $wisataId = $user->pengelola[0]->wisata_id;

        if(!empty($request->nama)){
            $model = Pengelola::where('wisata_id', $wisataId)
            ->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->nama.'%');
            })
            ->whereNotIn('user_id', [$user->id])
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = Pengelola::where('wisata_id', $wisataId)
            // ->whereHas('wisata', function ($query) use ($request) {
            //     $query->where('tipe_wisata', 'desa');
            // })
            ->whereNotIn('user_id', [$user->id])
            ->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
        }

        $data['data'] = $model;

        return view('backend.pengelola', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $data['page_name'] = "Buat Pengelola Wisata Baru";
        $data['page_description'] = "Buat pengelola wisata baru";
        $data['data'] = new Pengelola;

        return view('backend.pengelola_create', $data);
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
        $role = Role::where('name', 'operator')->firstOrFail();

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
        
        $wisataId = Auth::user()->pengelola[0]->wisata_id;
        $wisata = Wisata::findOrFail($wisataId);

        $pengelola = new Pengelola;
        $pengelola->wisata()->associate($wisata);
        $pengelola->user()->associate($user);
        $pengelola->save();

        return redirect()->route("backend::pengelola")->with('success', "Data berhasil di simpan.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(){
        $user = Auth::user();
        $data = User::findOrFail($user->id);

        $parse['page_name'] = "Ubah Pengelola";
        $parse['page_description'] = "Ubah pengelola";
        $parse['data'] = $data;
        $parse['action'] = 'edit';

        return view('backend.pengelola', $parse);
    }

    /**
     * Update the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $user = Auth::user();

        // validasi form
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'no_hp' => 'required|string|max:13'
        ]);

        if($user->email != $request->email){
            $this->validate($request, [
                'email' => 'required|string|email|max:255|unique:users'
            ]);
        }

        $user = User::findOrFail($user->id);
        $user->name = $request->name;
        $user->no_hp = $request->no_hp;
        $user->email = $request->email;
        $user->save();
        
        return redirect()->route("backend::pengelola")->with('success', "Data pengelola berhasil di ubah.");
    }

    /**
     * Delete the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $idUser, $idWisata){
        $data = Pengelola::where('user_id', $idUser)->where('wisata_id', $idWisata)->firstOrFail();
        $usr = User::findOrFail($idUser);
        $data->forceDelete();
        $usr->forceDelete();

        return redirect()->route("backend::pengelola")->with('success', "Data pengelola berhasil di hapus.");
    }
}