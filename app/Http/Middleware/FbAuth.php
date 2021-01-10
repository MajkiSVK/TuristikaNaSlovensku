<?php

namespace App\Http\Middleware;

use Closure;



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
        if(!session()->get('user_token')){
            return redirect(route('FbLogin'));
        }else{
        return $next($request);
        }
    }
}
