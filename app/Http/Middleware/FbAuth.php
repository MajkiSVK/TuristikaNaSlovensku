<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use Closure;
use Illuminate\Support\Facades\Session;


class FbAuth
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle($request, Closure $next)
    {
        if($this->userService->getFacebookId() !== 0 ){
            return $next($request);
        }else{
            return redirect(route('FbLogin'));
        }
    }
}
