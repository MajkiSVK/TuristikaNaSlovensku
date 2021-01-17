<?php

namespace App\Http\Controllers;

use App\Repository\ContestRepository;
use App\Repository\LikeRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ContestController extends Controller
{
    private $contestRepository;
    private $photoService;
    private $likeRepository;
    private $photoRepository;
    private $userRepository;


    public function __construct(ContestRepository $contestRepository,
                                PhotoService $photoService,
                                LikeRepository $likeRepository,
                                PhotoRepository $photoRepository,
                                UserRepository $userRepository)
    {

        $this->contestRepository = $contestRepository;
        $this->photoService = $photoService;
        $this->likeRepository = $likeRepository;
        $this->photoRepository = $photoRepository;
        $this->userRepository = $userRepository;
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

    /*
     * Show upload page
     */
    public function upload_page(Request $request)
    {
        $contest=$this->contestRepository->getBySlug($request);
        return view('pages.contest.upload')
            ->with('contest', $contest);
    }

    /*
     * Upload processing
     */
    public function upload_process(Request $request)
    {
        return $this->photoService->savePhoto($request);
    }
}
