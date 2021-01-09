<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use App\Services\FacebookService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;


class FacebookController extends Controller
{


    public function __construct(FacebookService $facebookService,
                                UserRepository $userRepository)
    {
        $this->FacebookService=$facebookService;
        $this->UserRepository=$userRepository;
    }
    public function login()
    {

        session()->put('previous_url', URL::previous());

        var_dump(session()->get('success'));
        var_dump(session()->get('previous_url'));
        return '<a href="http://localhost/turistika/public/facebook/redirect">Login</a>';

    }

    /*
     * Redirection to the FB auth with specific scopes
     */
    public function redirect()
    {
        return Socialite::driver('facebook')
            ->scopes('groups_access_member_info')
            ->redirect();

    }

    public function callback()
    {
        $user = Socialite::driver('facebook')->user();
        $is_member= $this->FacebookService->IsMember($user->token);
        $this->UserRepository->UpdateOrCreate($user);


        session()->put('user_token',$user->token);
        session()->put('name',$user->getName());
        session()->put('is_member',$is_member);

        return Redirect::to(session()->get('previous_url'))->with('success', 'Bol si úspešne prihlásený ako '.$user->Getname());
    }



}
