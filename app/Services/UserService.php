<?php

namespace App\Services;

use App\Http\Requests\SaveUserContactRequest;
use App\Repository\UserRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get User information from session
     * @return User
     */
    public function getLoggedInUserData(): User
    {
        if(!Session::get('user')){
            return new User();
        }

        return Session::get('user');
    }

    /**
     * Get user facebook ID from session
     * @return int
     */
    public function getFacebookId(): int
    {
        return $this->getLoggedInUserData()->facebook_id ?? 0 ;
    }

    /**
     * Save user contact information for contests
     * @param SaveUserContactRequest $request
     * @return Model
     */
    public function saveUserContactInformation(SaveUserContactRequest $request): Model
    {
        $user=$this->userRepository->saveUserPhoneNumber($this->getFacebookId(),$request);

        return $user->settings()->updateOrCreate(
            ['type' => 'contact_mail'],
            ['value'=> $request->contact_mail,
             'type'=> 'contact_mail',
             'expiration' => Carbon::now()
            ]);
    }

    /**
     * Remove user contact information from database
     * @return bool
     */
    public function removeUserContactInformation(): bool
    {
        $user=$this->userRepository->RemoveUserPhoneNumber($this->getFacebookId());

        return $user->settings()->where('type', 'contact_mail')->delete();
    }

    /**
     * Delete user profile from database
     * @return bool
     */
    public function deleteUserProfile(): bool
    {
        return $this->userRepository->DeleteUserProfile($this->getFacebookId());
    }

    /**
     * Generate session for previous URL
     */
    public function generatePreviousURL(): void
    {
        if (URL::previous()===URL::route('FbLogin')){
            Session::put('previous_url', URL::route('home'));
        }

        Session::put('previous_url', URL::previous());
    }
}
