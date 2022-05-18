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
            'password' => 'required',
            'captcha' => 'required|captcha'
        ], 
        ['captcha.captcha'=>'Invalid captcha code.']);

        $login = request()->input('usem');

        $dataUser = \App\User::
            where('email', '=', $login)
            ->orWhere('username', '=', $login)
            ->paginate(1);

        if (!empty($dataUser[0])) {
            // print_r("ADA");die();
            
            if ($dataUser[0]->status == 0) {
                return \Redirect::back()
                ->withInput()
                ->withErrors(
                    [
                        'password' => 'Akun anda belum terverifikasi',
                    ]
                );
            } elseif ($dataUser[0]->login_counter >= 5) {
                return \Redirect::back()
                ->withInput()
                ->withErrors(
                    [
                        'password' => 'Akun anda terblokir',
                    ]
                );
            }
        }

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        
        if (\Auth::attempt($request->except(['_token', 'usem', 'captcha']), $request->remember)) {
            $user = \App\User::findOrFail($dataUser[0]->id);
            $user->login_counter = 0;
            $user->save();

            // if successful -> redirect forward
            return redirect()->intended(route('backend::dashboard'));
        } else {

            if (!empty($dataUser[0])) {
                $user = \App\User::findOrFail($dataUser[0]->id);
                $user->login_counter = $dataUser[0]->login_counter + 1;
                $user->save();
            }
            
            // if unsuccessful -> redirect back
            return \Redirect::back()
            ->withInput()
            ->withErrors(
                [
                    'password' => 'Password yang anda masukkan tidak sesuai',
                ]
            );
        }
    }

    public function username()
    {
        $login = request()->input('email');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);

        return $field;
    }

}
