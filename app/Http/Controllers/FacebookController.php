<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use App\Services\FacebookService;
use App\Services\UserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    /**
     * @var FacebookService
     */
    private $facebookService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(FacebookService $facebookService,
                                UserRepository $userRepository,
                                UserService $userService)
    {
        $this->facebookService = $facebookService;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }
    /**
     * Login screen for facebook, making previous URL for redirection
     * @return Application|Factory|RedirectResponse|View
     */
    public function login()
    {
        $this->userService->generatePreviousURL();

        if ($this->userService->getFacebookId()){
            return Redirect::to(Session::get('previous_url'))
                ->with('error','Už si prihlásený, takže sa nemôžeš znova prihlásiť!');
        }

        return view('pages.fb_login');
    }

    /**
     * Redirection to the FB auth with specific scopes
     * @return RedirectResponse
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('facebook')
            ->scopes('groups_access_member_info')
            ->redirect();
    }

    /**
     * Get user informations from facebook, update/create user in database and log in him with redirection to previous URL
     */
    public function callback(): RedirectResponse
    {
        $user = Socialite::driver('facebook')->user();
        $userToLogIn = $this->userRepository->UpdateOrCreate($user);
        $userToLogIn->member=$this->facebookService->IsMember($user->token);

        Session::put('user', $userToLogIn);

        return Redirect::to(Session::get('previous_url'))
            ->with('success', 'Bol si úspešne prihlásený ako '.$user->Getname());
    }

    /**
     * Log out user
     */
    public function logout(): RedirectResponse
    {
        Session::forget(['user']);
        return Redirect::to(route('FbLogin'))
            ->with('success','Bol si úspešne odhlásený');
    }
}
