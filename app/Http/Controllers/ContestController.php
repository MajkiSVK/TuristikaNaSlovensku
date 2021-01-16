<?php

namespace App\Http\Controllers;

use App\Like;
use App\Repository\ContestRepository;
use App\Repository\LikeRepository;
use App\Services\LikeService;
use App\Services\PhotoService;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    private $contestRepository;
    private $photoService;
    private $likeRepository;


    public function __construct(ContestRepository $contestRepository,
                                PhotoService $photoService,
                                LikeRepository $likeRepository)
    {

        $this->contestRepository = $contestRepository;
        $this->photoService = $photoService;

        $this->likeRepository = $likeRepository;
    }
    /*
     * Show gallery page
     */
    public function gallery(Request $request)
    {
        /*Get contest details*/
        $contest=$this->contestRepository->galleryFirstOrFail($request->contest);

        return view('pages.contest.gallery')
                ->with('contest', $contest);
    }

    /*
     * Show photo page
     */
    public function photo(Request $request)
    {
        /*Get photo info with Next and Previous photo ID*/
        $photo=$this->photoService->GetPhotoWithNextPrev($request);

        /*Create Unique url identifier*/
        $url=$request->contest.'/'.$photo->id;

        /*Check if a user already voted for this photo*/
        $like=$this->likeRepository->checkLike(session()->get('facebook_id'),$url);

        /*Like counter for specific URL*/
        $like_number=$this->likeRepository->likeCounter($url);

        return view('pages.contest.photo')
            ->with('photo', $photo)
            ->with('like', $like)
            ->with('like_number', $like_number);
    }
}
