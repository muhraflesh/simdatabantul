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

class HomeController extends Controller{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data['page_name'] = "Dashboard";
        $data['page_description'] = "Control panel";

        return view('backend.dashboard', $data);
    }

    public function about(){
        $data['page_name'] = "About";
        $data['page_description'] = "About panel";

        return view('backend.about', $data);
    }
}