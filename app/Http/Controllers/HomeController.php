<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveUserContactRequest;
use App\Repository\ContestRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ContestRepository
     */
    private $contestRepository;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserRepository $userRepository,
                                ContestRepository $contestRepository,
                                UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->contestRepository = $contestRepository;
        $this->userService = $userService;
    }

    /**
     * Show the main page with user profile informations
     * @return View
     */
    public function main(): View
    {
        $user=$this->userRepository->GetUserByFacebookId($this->userService->getFacebookId());
        $user->contact_mail=$this->userService->getUserContactMail();
        $contests=$this->contestRepository->getAllActiveContests();
        return view('pages.home')
                    ->with('user', $user)
                    ->with('active_contests', $contests);
    }

    /**
     * Save user information
     * @param SaveUserContactRequest $request
     * @return RedirectResponse
     */
    public function save(SaveUserContactRequest $request): RedirectResponse
    {
        $this->userService->saveUserContactInformation($request);

        return back()->with('success', 'Tvoje údaje boli úspešne uložené');
    }

    /**
     *Delete user contact informations from database
     * @return RedirectResponse
     */
    public function delete_contact(): RedirectResponse
    {
        $this->userService->removeUserContactInformation();
        return back()->with('success', 'Tvoje údaje boli úspešne vymazané');
    }

    /**
     * Delete user profile from database
     * @return RedirectResponse
     */
    public function delete_profile(): RedirectResponse
    {
        $this->userService->deleteUserProfile();
        Session::forget(['user']);
        return Redirect::to(route('FbLogin'))->with('success','Tvoj profil bol úspešne vymazaný.');
    }
}
