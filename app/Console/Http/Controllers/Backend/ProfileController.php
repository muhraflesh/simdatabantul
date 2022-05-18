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
use App\Hotel;

class ProfileController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['page_name'] = "Profil";
        $data['page_description'] = "Control panel";
        $data['action'] = 'view';

        return view('backend.profile', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(){
        $user = Auth::user();
        $data = User::findOrFail($user->id);

        $parse['page_name'] = "Ubah Profil";
        $parse['page_description'] = "Ubah profil";
        $parse['data'] = $data;
        $parse['action'] = 'edit';

        return view('backend.profile', $parse);
    }

    /**
     * Update the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        $user = Auth::user();

        if($user->hasRole('superadmin')){
            // validasi form
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'no_hp' => 'max:13'
            ]);

            if(!empty($request->password)){
                $this->validate($request, [
                    'password' => 'string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
                ]);
            }

            if($user->email != $request->email){
                $this->validate($request, [
                    'email' => 'required|string|email|max:255|unique:users'
                ]);
            }

            $user = User::findOrFail($user->id);
            $user->name = $request->name;
            $user->no_hp = $request->no_hp;
            $user->email = $request->email;
            
            if((!empty($request->password))){
                $user->password = bcrypt($request->password);
            }
            $user->save();
        }

        if($user->hasRole('operator_hotel')){
            // validasi form
            $this->validate($request, [
                'nama_hotel' => 'required|string|max:255',
                'kontak' => 'max:13'
            ]);

            if(!empty($request->password)){
                $this->validate($request, [
                    'password' => 'string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
                ]);
            }

            $hotel = Hotel::findOrFail($user->hotel->id);
            $hotel->nama_hotel = $request->nama_hotel;
            $hotel->alamat_hotel = $request->alamat;
            $hotel->kontak_hotel = $request->kontak;
            $hotel->save();
            
            $user = User::findOrFail($user->id);
            $user->no_hp = $request->kontak;
            if((!empty($request->password))){
                $user->password = bcrypt($request->password);
            }
            $user->save();
        }

        if($user->hasRole('operator')){
            if(!empty($request->password)){
                $this->validate($request, [
                    'password' => 'string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
                ]);
            }

            $user = User::findOrFail($user->id);

            if(!empty($user->pengelola)){
                $this->validate($request, [
                    'nama_wisata' => 'required|string|max:255',
                    'jam_buka' => 'required|string|max:13'
                ]);
                $wisata = Wisata::findOrFail($user->pengelola[0]->wisata_id);

                $wisata->nama = $request->nama_wisata;
                $wisata->jam_buka = $request->jam_buka;
                $wisata->save();
            }

            if((!empty($request->password))){
                $user->password = bcrypt($request->password);
            }
            $user->save();
        }
        
        return redirect()->route("backend::profile")->with('success', "Profil berhasil di ubah.");
    }
}