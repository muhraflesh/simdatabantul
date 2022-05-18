<?php

namespace App\Http\Middleware;

use Closure;

class CheckPengelola
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $tipe)
    {
        if(\Auth::user()->hasRole('operator')){
            if (empty(\Auth::user()->pengelola)) {
                return redirect()->route('backend::dashboard')->with('warning', "Anda belum memiliki akses kelola obyek/desa wisata.");
            }

            $user = \Auth::user();
            if($tipe!="*"){
                if($tipe != $user->pengelola[0]->wisata->tipe_wisata){
                    return redirect()->route('backend::dashboard')->with('warning', "Anda tidak memiliki akses kelola {$tipe} wisata.");
                }
            }
        }

        return $next($request);
    }
}
