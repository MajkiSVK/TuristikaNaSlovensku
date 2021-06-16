<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContestPhotoRequest;
use App\Repository\ContestRepository;
use App\Repository\LikeRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use App\Services\PhotoService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;


class ContestController extends Controller
{
    private $contestRepository;
    private $photoService;
    private $likeRepository;
    private $photoRepository;
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;


    public function __construct(ContestRepository $contestRepository,
                                PhotoService $photoService,
                                LikeRepository $likeRepository,
                                PhotoRepository $photoRepository,
                                UserRepository $userRepository,
                                UserService $userService)
    {

        $this->contestRepository = $contestRepository;
        $this->photoService = $photoService;
        $this->likeRepository = $likeRepository;
        $this->photoRepository = $photoRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }
    /*
     * Show gallery page
     */
    public function gallery(Request $request)
    {
        $contest=$this->contestRepository->getContestBySlug($request->contest);

        return view('pages.contest.gallery')
                ->with('contest', $contest);
    }

    /**
     * Get all information about specific photo and make view for her
     * @param Request $request
     * @return View
     */
    public function photo(Request $request): View
    {
        /*Get photo info with Next and Previous photo ID*/
        $photo=$this->photoService->GetPhotoWithNextPrev($request);
        $url=$request->contest.'/'.$photo->id;

        /*Check if a user already voted for this photo and counter all likes for specific photo*/
        $like=$this->likeRepository->checkLike($this->userService->getFacebookId(),$url);
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
    public function upload_process(ContestPhotoRequest $request)
    {
        return $this->photoService->savePhoto($request);
    }
}
