<?php


namespace App\Repository;


use App\Http\Requests\SaveUserContactRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserRepository
{
    /**
     * Update or create a user during login.
     * @param $user
     * @return mixed
     */
    public function UpdateOrCreate($user)
    {

        $id=['facebook_id'=> $user->getId()];
        $table=[
                'name'=> $user->getName(),
                'email'=> $user->getEmail()];

        return User::updateOrCreate($id,$table);
    }

    /**
     * Find user by facebook_id
     * @param int $facebook_id
     * @return User
     */
    public function GetUserByFacebookId(int $facebook_id): User
    {
        return User::WHERE('facebook_id', $facebook_id)->firstOrFail();
    }

    /**
     * Save a user phone number and return back user
     * @param int $facebook_id
     * @param SaveUserContactRequest $request
     * @return User
     */
    public function SaveUserPhoneNumber(int $facebook_id,SaveUserContactRequest $request): User
    {
        $user= User::WHERE('facebook_id', $facebook_id)->firstOrFail();
        $user->phone_number=$request->user_phone;
        $user->save();

        return $user;
    }

    /**
     * Remove a user contact information
     */
    public function RemoveUserContact(int $facebook_id)
    {
        $user= User::WHERE('facebook_id', $facebook_id)->firstOrFail();
        $user->phone_number=NULL;
        $user->save();
        $user->settings()->where('type', 'contact_mail')->delete();

        return back()->with('success', 'Tvoje údaje boli úspešne vymazané');
    }

    /*
     * Delete a user profile from database
     */
    public function DeleteUserProfile($facebook_id)
    {
        $user= User::WHERE('facebook_id', $facebook_id)->firstOrFail();
        $user->delete();

        return Redirect::to(route('FbLogin'))->with('success','Tvoj profil bol úspešne vymazaný.');
    }

}
