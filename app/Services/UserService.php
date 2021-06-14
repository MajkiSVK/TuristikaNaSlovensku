<?php


namespace App\Services;


use App\Http\Requests\SaveUserContactRequest;
use App\Repository\UserRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

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

    public function getLoggedInUserObject(): User
    {
        if(!Session::get('user')){
            return new User();
        }

        return Session::get('user');
    }

    public function getFacebookId(): int
    {
        return $this->getLoggedInUserObject()->facebook_id ?? 0 ;
    }

    /**
     * Save user contact information
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
}
