<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /*
     * Show the main page with user profile informations
     */
    public function main()
    {
        $user=$this->userRepository->FirstOrFail(session()->get('facebook_id'));
        return view('pages.home')
                    ->with('user', $user);
    }

    /*
     * Save user information
     */
    public function save(Request $request)
    {
        $save=$this->userRepository->saveUserContact(session()->get('facebook_id'),$request);
        return $save;
    }

    /*
     *Delete user contact informations
     */
    public function delete_contact()
    {
        $delete=$this->userRepository->RemoveUserContact(session()->get('facebook_id'));
        return $delete;
    }

    /*
     * Delete user profile
     */
    public function delete_profile()
    {
        $delete_profile=$this->userRepository->DeleteUserProfile(session()->get('facebook_id'));
        session()->forget(['user_token','name','facebook_id']);
        return $delete_profile;
    }
}
