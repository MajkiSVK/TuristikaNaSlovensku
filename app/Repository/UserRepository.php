<?php


namespace App\Repository;


use App\User;

class UserRepository
{
    public function UpdateOrCreate($user)
    {

        $id=['facebook_id'=> $user->getId()];
        $table=[
                'name'=> $user->getName(),
                'email'=> $user->getEmail()];

        return User::updateOrCreate($id,$table);
    }

    public function FirstOrFail($facebook_id)
    {
        return User::WHERE('facebook_id', $facebook_id)->firstOrFail()->toArray();
    }
}
