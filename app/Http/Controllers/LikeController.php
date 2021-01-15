<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /*
     * Add like for photos
     */
    public function add_like(Request $request)
    {
        $facebook_id=session()->get('facebook_id');
        /* Make unique "URL" key */
        $url=$request->slug.'/'.$request->photo_id;
        /*Check if a user already voted for this photo*/
        $check_like=Like::where('facebook_id',$facebook_id)->where('URL', $url)->first();

        if (!empty($check_like)){
           return back()->with('error','Za túto fotku už si hlasoval! Nemôžeš hlasovať viac krát');
        }

        if ($facebook_id){
            $new_like=new Like();
            $new_like->facebook_id=$facebook_id;
            $new_like->URL=$url;
            $new_like->save();
            return back();
        }else{
            return back()->with('error','Pre hlasovanie sa musíš prihlásiť');
        }
    }

    /*
     * Delete like for specific photo
     */
    public function delete_like(Request $request)
    {
        $facebook_id=session()->get('facebook_id');
        $url=$request->slug.'/'.$request->photo_id;
        $like=Like::where('facebook_id', $facebook_id)->where('URL', $url)->firstOrFail();
        $like->delete();
        return back();
    }
}
