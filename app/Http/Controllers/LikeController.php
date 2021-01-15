<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function add_like(Request $request)
    {
        $facebook_id=session()->get('facebook_id');
        $url=$request->slug.'/'.$request->photo_id;
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

    public function delete_like(Request $request)
    {
        $facebook_id=session()->get('facebook_id');
        $url=$request->slug.'/'.$request->photo_id;
        $like=Like::where('facebook_id', $facebook_id)->where('URL', $url)->firstOrFail();
        $like->delete();
        return back();
    }
}
