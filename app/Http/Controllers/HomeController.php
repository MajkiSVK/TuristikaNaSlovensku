<?php

namespace App\Http\Controllers;

use App\Repository\ContestRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    private $userRepository;
    private $contestRepository;

    public function __construct(UserRepository $userRepository,
                                ContestRepository $contestRepository)
    {
        $this->userRepository = $userRepository;
        $this->contestRepository = $contestRepository;
    }

    /*
     * Show the main page with user profile informations
     */
    public function main()
    {
        $user=$this->userRepository->FirstOrFail(Session::get('user')->facebook_id);
        $contests= $this->contestRepository->getAllActiveContests();
        return view('pages.home')
                    ->with('user', $user)
                    ->with('active_contests', $contests);
    }

    /*
     * Save user information
     */
    public function save(Request $request)
    {
        $save=$this->userRepository->saveUserContact(Session::get('user')->facebook_id,$request);
        return $save;
    }

    /*
     *Delete user contact informations
     */
    public function delete_contact()
    {
        $delete=$this->userRepository->RemoveUserContact(Session::get('user')->facebook_id);
        return $delete;
    }

    /*
     * Delete user profile
     */
    public function delete_profile()
    {
        $delete_profile=$this->userRepository->DeleteUserProfile(Session::get('user')->facebook_id);
        Session::forget(['user']);
        return $delete_profile;
    }
}
