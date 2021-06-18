<?php

namespace App\Http\Controllers;

use App\Repository\LikeRepository;
use App\Services\LikeService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * @var LikeRepository
     */
    private $likeRepository;

    /**
     * @var LikeService
     */
    private $likeService;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(LikeRepository $likeRepository,
                                LikeService $likeService,
                                UserService $userService)
    {
        $this->likeRepository = $likeRepository;
        $this->likeService = $likeService;
        $this->userService = $userService;
    }

    /**
     * Add like for photo, if user is logged in and not voted yet.
     * @param Request $request
     * @return RedirectResponse
     */
    public function add_like(Request $request): RedirectResponse
    {
        $facebook_id = $this->userService->getFacebookId();
        /* Make unique "URL" key */
        $url = $request->slug.'/'.$request->photo_id;

        return $this->likeService->add_like($facebook_id,$url);
    }

    /**
     * Delete like for specific photo
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete_like(Request $request): RedirectResponse
    {
        $facebook_id = $this->userService->getFacebookId();
        $url = $request->slug.'/'.$request->photo_id;
        $this->likeRepository->delete_like($facebook_id,$url);

        return back();
    }
}
