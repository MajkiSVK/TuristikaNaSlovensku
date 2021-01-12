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

    /*
     * Login screen for facebook
     */
    public function login()
    {
        /*
         * Make session for URL, where will be redirected user after facebook callback
         */
        if (URL::previous()===URL::route('FbLogin')){
            session()->put('previous_url', URL::route('home'));
        }else{
            session()->put('previous_url', URL::previous());
        }
        /*
         * If the user is logged in, redirect to the previous URL
         */
        if (session()->get('user_token')){
            return Redirect::to(session()->get('previous_url'))->with('error','Už si prihlásený, takže sa nemôžeš znova prihlásiť!');
        }

        return view('pages.fb_login');

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
        /*
         * Get user informations from facebook and update/create user in database
         */
        $user = Socialite::driver('facebook')->user();
        $this->UserRepository->UpdateOrCreate($user);

        /*
         * Save user token and name to session
         */
        session()->put('user_token',$user->token);
        session()->put('name',$user->getName());
        session()->put('facebook_id',$user->getId());

        /*
         * Redirect to url "before" Login screen
         */
        return Redirect::to(session()->get('previous_url'))->with('success', 'Bol si úspešne prihlásený ako '.$user->Getname());
    }

    public function logout()
    {
        session()->forget(['user_token','name','facebook_id']);
        return Redirect::to(route('FbLogin'))->with('success','Bol si úspešne odhlásený');
    }



}
