<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ValidarUsuarioEsDocente
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
        if(Auth::user()->charge == 'docente'){
            return $next($request);
        }
        return back()->with('status-warning', 'No tiene los permisos necesarios.');
    }
}
