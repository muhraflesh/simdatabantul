<?php
/*
 * @Author: Ferdhika Yudira 
 * @Website: http://dika.web.id 
 * @Date:   2018-07-26 10:28:02 
 * @Email: fer@dika.web.id 
 */
namespace App\Http\Controllers\Backend\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pengelola;
use App\Wisata;

class ObyekWisataController extends Controller{

    public $routePath = "backend::pengelola.obyek_wisata";
    public $prefix = "backend.pengelola.obyek_wisata";

    function __construct(){
        $this->prefix = 'backend.pengelola.obyek_wisata';
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data['page_name'] = "Pengelola Obyek Wisata";
        $data['page_description'] = "Pengelola data Obyek Wisata";

        if(!empty($request->nama)){
            $model = Pengelola::whereHas('wisata', function ($query) use ($request) {
                $query->where('nama', 'like', '%'.$request->nama.'%')->where('tipe_wisata', 'obyek');
            })
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        }else{
            $model = Pengelola::whereHas('wisata', function ($query) use ($request) {
                $query->where('tipe_wisata', 'obyek');
            })->whereNull('deleted_at')->orderBy('created_at', 'asc')->paginate(10);
        }

        $data['data'] = $model;

        return view($this->prefix.'.list', $data);
    }
}