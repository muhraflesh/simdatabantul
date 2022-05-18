<?php

namespace App\Http\Middleware;

use Closure;

class CheckPengelolaDesaWisata
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->pengelola[0]->wisata->tipe_wisata!='desa') {
            return redirect()->route('backend::dashboard')->with('warning', "Anda tidak memiliki akses kelola desa wisata.");
        }

        return $next($request);
    }
}
