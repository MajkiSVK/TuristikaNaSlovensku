<?php


namespace App\Services;


use App\User;
use Illuminate\Support\Facades\Session;

class UserService
{
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
}
