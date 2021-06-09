<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;


class FbAuth
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
        if(Session::get('user')){
            return $next($request);
        }else{
            return redirect(route('FbLogin'));
        }
    }
}
