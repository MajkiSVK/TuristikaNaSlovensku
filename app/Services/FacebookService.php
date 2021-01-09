<?php


namespace App\Services;


class FacebookService
{
    /*
     * Check, if the user is a member of FB group Turistika na Slovensku
     */
    public function IsMember($user_token)
    {
        $client= new \GuzzleHttp\Client();
        $url= 'https://graph.facebook.com/v9.0/me/groups';
        $limit='100000';
        $request= $client->get($url, ['query'=>['limit'=>$limit, 'access_token'=>$user_token]]);
        $decoded=json_decode($request->getBody());
        $is_member=false;
        foreach ($decoded->data as $group){

            if ($group->id==='82618591890'){
                $is_member=true;
            }
        }
        return $is_member;
    }
}

