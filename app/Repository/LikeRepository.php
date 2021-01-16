<?php


namespace App\Repository;


use App\Like;

class LikeRepository
{
    /*
     * Check, if a user already voted for the photo
     */
    public function check_like($facebook_id,$url)
    {
        return Like::where('facebook_id',$facebook_id)->where('URL', $url)->first();
   }

   /*
    * Add like for photo
    */
    public function add_like($facebook_id,$url)
    {
        $new_like=new Like();
        $new_like->facebook_id=$facebook_id;
        $new_like->URL=$url;
       return $new_like->save();
    }

    /*
     * Delete like for photo, if a user voted (else error 404)
     */
    public function delete_like($facebook_id,$url)
    {
        $like=Like::where('facebook_id', $facebook_id)->where('URL', $url)->firstOrFail();
        $like->delete();
        return back();
    }

    /*
     * Check if the user already voted
     */
    public function checkLike($facebook_id,$url)
    {
        return  Like::where('facebook_id',$facebook_id)->where('URL', $url)->first();
    }

    /*
     * Like counter for specific URL
     */
    public function likeCounter($url)
    {
        return Like::where('URL', $url)->count();
    }


}
