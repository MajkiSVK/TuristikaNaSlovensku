<?php

namespace App\Http\Controllers;

use App\Repository\ContestRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $contests= $this->contestRepository->getAllActiveContests();
        return view('pages.home')
                    ->with('user', $user)
                    ->with('active_contests', $contests);
    }

    /**
     * Save user information
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $save=$this->userRepository->saveUserContact($this->userService->getFacebookId(),$request);
        return $save;
    }

    /**
     *Delete user contact informations from database
     * @return RedirectResponse
     */
    public function delete_contact(): RedirectResponse
    {
        $delete=$this->userRepository->RemoveUserContact($this->userService->getFacebookId());
        return $delete;
    }

    /**
     * Delete user profile from database
     * @return RedirectResponse
     */
    public function delete_profile(): RedirectResponse
    {
        $delete_profile=$this->userRepository->DeleteUserProfile($this->userService->getFacebookId());
        Session::forget(['user']);
        return $delete_profile;
    }
}
