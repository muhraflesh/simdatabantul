<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-26 10:28:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;
use App\Wisata;
use App\Pengelola;

class TemplateDocController extends Controller{

    function __construct(){
        $this->prefix = 'template_doc';
    }

    public function index(Request $request){
        $data['page_name'] = "Template Doc";

        return view($this->prefix, $data);
    }

    public function download($name, Request $request){
        // print_r($name);die();

        if ($name == 'susunan_pengurus'){
            $file= "uploads/template_doc_registrasi/Template_Lampiran_Susunan_Pengurus.docx";
        } elseif ($name == 'permohonan_registrasi') {
            $file= "uploads/template_doc_registrasi/Template_Lampiran_Permohonan_Registrasi.docx";
        } elseif ($name == 'foto_deskripsi') {
            $file= "uploads/template_doc_registrasi/Template_Lampiran_Foto_Deskripsi.docx";
        } else {
            $file= $name;
        }
        
        return response()->download($file);
    }

}