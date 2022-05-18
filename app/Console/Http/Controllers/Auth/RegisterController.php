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
            'nama_destinasi' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/|confirmed',
        ]);
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
        $role = \App\Role::where('name', 'operator_hotel')->firstOrFail();

        $user = new \App\User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->no_hp = "";
        $user->deskripsi = "";
        $user->status = false;
        $user->password = bcrypt($data['password']);

        $user->save();
        $user->attachRole($role);

        $id_hotel = '';
        $id_wisata = '';

        if ($data['kategori_akun'] == 'hotel') {
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
            $wisata = new \App\Wisata;
            $wisata->nama = $data['nama_destinasi'];
            $wisata->alamat = $data['alamat'];
            $wisata->kelurahan_id = $data['kelurahan'];
            $wisata->tipe_wisata = $data['tipe_wisata'];
            $wisata->save();

            $id_hotel = \App\Hotel::where('nama_hotel', $data['nama_destinasi'])->firstOrFail();
            $id_hotel = $id_hotel->id;
        }

        $pengajuan = new \App\Pengajuan;
        $pengajuan->path_file_susunan_pengurus = "path_file_susunan_pengurus";
        $pengajuan->path_file_permohonan_registrasi = "path_file_permohonan_registrasi";
        $pengajuan->path_file_foto_deskripsi = "path_file_foto_deskripsi";
        $pengajuan->tanggal_pengajuan = '';
        $pengajuan->status = 0;
        $pengajuan->id_hotel = $id_hotel;
        $pengajuan->id_wisata = $id_wisata;
        $pengajuan->save();

        // print_r($user);die();
        return $user;

    }
}
