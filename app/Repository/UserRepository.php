<?php


namespace App\Repository;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class UserRepository
{
    /*
     * Update or create a user during login.
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
    public function GetUserByFacebookId(int $facebook_id)
    {
        return User::WHERE('facebook_id', $facebook_id)->firstOrFail();
    }

    /*
     * Save a user contact information
     */
    public function SaveUserContact($facebook_id, $request)
    {
        if(empty($request->user_phone)){
            return back()->with('error','Telefónne číslo nesmie ostať prázdne');
        }

        if(empty($request->contact_mail)){
            return back()->with('error','Kontaktný E-mail nesmie ostať prázdny');
        }
        $user= User::WHERE('facebook_id', $facebook_id)->firstOrFail();
        $user->phone_number=$request->user_phone;
        $user->save();
        $user->settings()->updateOrCreate(
            ['type' => 'contact_mail'],
            ['value'=> $request->contact_mail,
             'type'=> 'contact_mail',
             'expiration' => Carbon::now()
            ]
        );


        return back()->with('success', 'Tvoje údaje boli úspešne uložené');

    }

    /*
     * Remove a user contact information
     */
    public function RemoveUserContact($facebook_id)
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
