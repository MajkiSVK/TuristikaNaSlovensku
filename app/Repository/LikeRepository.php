<?php

namespace App\Repository;

use App\Like;

class LikeRepository
{
    /**
     * Check, if a user already voted for the photo
     * @param int $facebook_id
     * @param string $url
     * @return mixed
     */
    public function check_like(int $facebook_id,string $url)
    {
        return Like::where('facebook_id',$facebook_id)->where('URL', $url)->first();
   }

    /**
     * Add like for photo
     * @param int $facebook_id
     * @param string $url
     * @return bool
     */
    public function add_like(int $facebook_id,string $url): bool
    {
        $new_like = new Like();
        $new_like->facebook_id = $facebook_id;
        $new_like->URL = $url;
       return $new_like->save();
    }

    /**
     * Delete like for photo, if a user voted
     * @param int $facebook_id
     * @param string $url
     * @return bool
     */
    public function delete_like(int $facebook_id,string $url): bool
    {
        $like=Like::where('facebook_id', $facebook_id)->where('URL', $url)->firstOrFail();
        return $like->delete();
    }

    /**
     * Like counter for specific URL
     * @param string $url
     * @return int
     */
    public function likeCounter(string $url): int
    {
        return Like::where('URL', $url)->count();
    }


}
