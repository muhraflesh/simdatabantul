<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            ->where('pengajuan_destinasi.status', '=', '0')
            ->orWhere('wisata.nama', 'like', '%'.$request->nama.'%')
            ->orWhere('hotel.nama_hotel', 'like', '%'.$request->nama.'%')
            ->orderBy('pengajuan_destinasi.created_at', 'asc')
            ->paginate(10);
        }else{
            $model = \App\Pengajuan::
            leftJoin('hotel', 'hotel.id', '=', 'pengajuan_destinasi.id_hotel')
            ->leftJoin('wisata', 'wisata.id', '=', 'pengajuan_destinasi.id_wisata')
            ->where('pengajuan_destinasi.status', '=', '0')
            ->orderBy('pengajuan_destinasi.created_at', 'asc')
            ->paginate(10);
        }

        $data['data'] = $model;

        return view($this->prefix.'.list', $data);
    }

    public function edit($id){
        $data = \App\Pengajuan::
        leftJoin('hotel', 'hotel.id', '=', 'pengajuan_destinasi.id_hotel')
        ->leftJoin('wisata', 'wisata.id', '=', 'pengajuan_destinasi.id_wisata')
        ->where('pengajuan_destinasi.id_pengajuan', '=', $id)
        ->get();

        $parse['page_name'] = "Persetujuan Registrasi";
        $parse['page_description'] = "Persetujuan Registrasi";
        $parse['data'] = $data;

        // print_r($data);die();

        return view($this->prefix.'.edit', $parse);
    }

    public function update($id, Request $request){
        
        $dataPengajuan = \App\Pengajuan::
        leftJoin('hotel', 'hotel.id', '=', 'pengajuan_destinasi.id_hotel')
        ->leftJoin('wisata', 'wisata.id', '=', 'pengajuan_destinasi.id_wisata')
        ->where('pengajuan_destinasi.id_pengajuan', '=', $id)
        ->get();

        $user_id = 0;

        if((!empty($dataPengajuan[0]->user_id))){
            $user_id = $dataPengajuan[0]->user_id;
        } else {
            $user_id = $dataPengajuan[0]->user_id_wisata;
        }

        $datauser = User::findOrFail($user_id);
        try{
            Mail::send([], [], function ($message) use ($datauser) {
                $message->subject("Selamat! Akun anda telah aktif.");
                $message->setBody('<h3>Selamat, akun anda sudah disetujui dan sudah aktif</h3>', 'text/html'); 
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($datauser->email);
            });

        } catch (Exception $e){
            dd($e->getMessage());
            return response (['status' => false,'errors' => $e->getMessage()]);
        }

        $user = User::findOrFail($user_id);
        $user->status = 1;
        $user->save();

        $pengajuan = \App\Pengajuan::where('id_pengajuan', $id)->firstOrFail();
        $pengajuan->status = 1;
        $pengajuan->save();

        return redirect()->route($this->routePath. ".index")->with('success', "Registrasi destinasi berhasil di setujui.");
    }

}