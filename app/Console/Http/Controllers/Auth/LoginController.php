<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // validate the form data
        $this->validate($request, [
            'usem' => 'required',
            'password' => 'required'
        ]);
        
        $login = request()->input('usem');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);

        // print_r($login);die();

        // status aktif
        request()->merge(['status' => 1]);

        // dd($request->except(['_token', 'usem']));
        
        // attempt to log
        if (\Auth::attempt($request->except(['_token', 'usem']), $request->remember)) {

            // if successful -> redirect forward
            return redirect()->intended(route('backend::dashboard'));
        }
        
        // if unsuccessful -> redirect back
        return \Redirect::back()
                ->withInput()
                ->withErrors(
                    [
                        'password' => 'Password salah, atau akun anda belum disetujui',
                    ]
                    // ,[
                    //     'approve' => 'Account not approved',
                    // ]
                );
    }

    public function username()
    {
        $login = request()->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);

        return $field;
    }
}
