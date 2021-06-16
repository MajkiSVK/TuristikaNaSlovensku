<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use App\Services\FacebookService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    /**
     * @var FacebookService
     */
    private $FacebookService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserRepository
     */
    private $UserRepository;

    public function __construct(FacebookService $facebookService,
                                UserRepository $userRepository,
                                UserService $userService)
    {
        $this->FacebookService=$facebookService;
        $this->UserRepository=$userRepository;
        $this->userService = $userService;
    }

    /*
     * Login screen for facebook, making previous URL for redirection
     */
    public function login()
    {
        $this->userService->generatePreviousURL();

        if ($this->userService->getFacebookId()){
            return Redirect::to(Session::get('previous_url'))->with('error','Už si prihlásený, takže sa nemôžeš znova prihlásiť!');
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

    /*
     * Get user informations from facebook, update/create user in database and log in him with redirection to previous URL
     */
    public function callback(): RedirectResponse
    {
        $user = Socialite::driver('facebook')->user();
        $userToLogIn=$this->UserRepository->UpdateOrCreate($user);

        Session::put('user', $userToLogIn);

        return Redirect::to(Session::get('previous_url'))->with('success', 'Bol si úspešne prihlásený ako '.$user->Getname());
    }

    /*
     * Log out user
     */
    public function logout(): RedirectResponse
    {
        Session::forget(['user']);
        return Redirect::to(route('FbLogin'))->with('success','Bol si úspešne odhlásený');
    }



}
