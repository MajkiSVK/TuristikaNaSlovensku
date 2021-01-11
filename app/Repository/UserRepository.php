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

    public function SaveUserContact($facebook_id, $request)
    {
        if(empty($request->user_phone)){
            return back()->with('error','Telefónne číslo nesmie ostať prázdne');
        }
        $user= User::WHERE('facebook_id', $facebook_id)->firstOrFail();
        $user->phone_number=$request->user_phone;
        $user->save();

        return back()->with('success', 'Tvoje údaje boli úspešne uložené');

    }

    public function RemoveUserContact($facebook_id)
    {
        $user= User::WHERE('facebook_id', $facebook_id)->firstOrFail();
        $user->phone_number='';
        $user->save();
        return back()->with('success', 'Tvoje údaje boli úspešne vymazané');
    }
}
