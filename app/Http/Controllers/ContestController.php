<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContestPhotoRequest;
use App\Repository\ContestRepository;
use App\Repository\LikeRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use App\Services\PhotoService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContestController extends Controller
{
    /**
     * @var ContestRepository
     */
    private $contestRepository;

    /**
     * @var PhotoService
     */
    private $photoService;

    /**
     * @var LikeRepository
     */
    private $likeRepository;

    /**
     * @var PhotoRepository
     */
    private $photoRepository;

    /**
     * @var UserRepository
     */
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

    /**
     * Show gallery page for user
     * @param Request $request
     * @return View
     */
    public function gallery(Request $request):View
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

    /**
     * Show upload page for user
     * @param Request $request
     * @return View
     */
    public function upload_page(Request $request): View
    {
        return view('pages.contest.upload')
            ->with('contest', $this->contestRepository->getContestBySlug($request->contest));
    }

    /**
     * Image uploading process for contest
     * @param ContestPhotoRequest $request
     * @return RedirectResponse
     */
    public function upload_process(ContestPhotoRequest $request): RedirectResponse
    {
        return $this->photoService->savePhoto($request);
    }
}
