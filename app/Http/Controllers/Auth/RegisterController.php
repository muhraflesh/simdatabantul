<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/successregis';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'jenis' => 'required',
            'kategori_akun' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'nama_destinasi' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'doc_susunan_pengurus' => 'required|mimes:doc,docx|max:5048',
            'doc_permohonan_registrasi' => 'required|mimes:doc,docx|max:5048',
            'doc_foto_deskripsi' => 'required|mimes:doc,docx|max:5048',
            'captcha' => 'required|captcha'
        ],
        ['captcha.captcha'=>'Invalid captcha code.']);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // Pengguna
        $roleHotel = \App\Role::where('name', 'operator_hotel')->firstOrFail();
        $roleWisata = \App\Role::where('name', 'operator')->firstOrFail();

        $user = new \App\User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->no_hp = "";
        $user->deskripsi = "";
        $user->status = false;
        $user->password = bcrypt($data['password']);

        $user->save();

        $id_hotel = '';
        $id_wisata = '';

        if ($data['kategori_akun'] == 'hotel') {
            $user->attachRole($roleHotel);

            $hotel = new \App\Hotel;
            $hotel->nama_hotel = $data['nama_destinasi'];
            $hotel->alamat_hotel = $data['alamat'];
            $hotel->kontak_hotel = "";
            $hotel->email_hotel = $data['email'];
            $hotel->jenis_hotel = $data['jenis'];
            $hotel->user()->associate($user);
            $hotel->save();

            $id_hotel = \App\Hotel::where('nama_hotel', $data['nama_destinasi'])->firstOrFail();
            $id_hotel = $id_hotel->id;
        } else {
            $user->attachRole($roleWisata);

            $wisata = new \App\Wisata;
            $wisata->nama = $data['nama_destinasi'];
            $wisata->alamat = $data['alamat'];
            $wisata->kelurahan_id = $data['kelurahan'];
            $wisata->tipe_wisata = $data['tipe_wisata'];
            
            $user_id = \App\User::where('username', $data['username'])->firstOrFail();
            $user_id = $user_id->id;
            
            $wisata->user_id_wisata = $user_id;
            $wisata->save();

            $id_wisata = \App\Wisata::where('nama', $data['nama_destinasi'])->firstOrFail();
            $id_wisata = $id_wisata->id;

            $wisata_pengelola = \App\Wisata::findOrFail($id_wisata);
            $user_pengelola = \App\User::findOrFail($user_id);

            $pengelola = new \App\Pengelola;
            $pengelola->wisata()->associate($wisata_pengelola);
            $pengelola->user()->associate($user_pengelola);
            $pengelola->save();
        }

        // DOKUMEN SUSUNAN PENGURUS
        $doc_pengurus = $data['doc_susunan_pengurus'];
        $fileName_pengurus = str_replace(" ","_",$data['name']).'_susunan_pengurus_'.time().'.'.$doc_pengurus->getClientOriginalExtension();
        $doc_pengurus->move(public_path("/uploads/doc_registrasi/".$data['name']."/"), $fileName_pengurus);
        $pathFile_pengurus = 'uploads/doc_registrasi/'.$data['name'].'/'.$fileName_pengurus;

        // DOKUMEN PERMOHONAN REGISTRASI
        $doc_permohonan = $data['doc_permohonan_registrasi'];
        $fileName_permohonan = str_replace(" ","_",$data['name']).'_permohonan_'.time().'.'.$doc_permohonan->getClientOriginalExtension();
        $doc_permohonan->move(public_path("/uploads/doc_registrasi/".$data['name']."/"), $fileName_permohonan);
        $pathFile_permohonan = 'uploads/doc_registrasi/'.$data['name'].'/'.$fileName_permohonan;

        // DOKUMEN FOTO DESKRIPSI
        $doc_foto_deskripsi = $data['doc_foto_deskripsi'];
        $fileName_foto_deskripsi = str_replace(" ","_",$data['name']).'_foto_deskripsi_'.time().'.'.$doc_foto_deskripsi->getClientOriginalExtension();
        $doc_foto_deskripsi->move(public_path("/uploads/doc_registrasi/".$data['name']."/"), $fileName_foto_deskripsi);
        $pathFile_foto_deskripsi = 'uploads/doc_registrasi/'.$data['name'].'/'.$fileName_foto_deskripsi;

        $pengajuan = new \App\Pengajuan;
        $pengajuan->path_file_susunan_pengurus = $pathFile_pengurus;
        $pengajuan->path_file_permohonan_registrasi = $pathFile_permohonan;
        $pengajuan->path_file_foto_deskripsi = $pathFile_foto_deskripsi;
        $pengajuan->tanggal_pengajuan = date('Y-m-d H:i:s');
        $pengajuan->status = 0;
        $pengajuan->id_hotel = $id_hotel;
        $pengajuan->id_wisata = $id_wisata;
        $pengajuan->save();

        // print_r($user);die();
        return $user;

    }
}
