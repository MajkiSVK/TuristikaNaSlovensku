<?php

namespace App\Http\Controllers;

use App\Like;
use App\Repository\LikeRepository;
use App\Services\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    private $likeRepository;
    private $likeService;

    public function __construct(LikeRepository $likeRepository,
                                LikeService $likeService)
    {
        $this->likeRepository = $likeRepository;
        $this->likeService = $likeService;
    }

    /*
     * Add like for photo, if user is logged in and not voted yet.
     */
    public function add_like(Request $request)
    {
        $facebook_id=session()->get('facebook_id');
        /* Make unique "URL" key */
        $url=$request->slug.'/'.$request->photo_id;


        return $this->likeService->add_like($facebook_id,$url);
    }
    /*
     * Delete like for specific photo
     */
    public function delete_like(Request $request)
    {
        $facebook_id=session()->get('facebook_id');
        $url=$request->slug.'/'.$request->photo_id;

        return $this->likeRepository->delete_like($facebook_id,$url);
    }
}
