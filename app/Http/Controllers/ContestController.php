<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Like;
use App\Photo;
use App\Repository\ContestRepository;
use App\Services\PhotoService;
use App\User;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    private $contestRepository;
    private $photoService;

    public function __construct(ContestRepository $contestRepository,
                                PhotoService $photoService)
    {

        $this->contestRepository = $contestRepository;
        $this->photoService = $photoService;
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
        $like=Like::where('facebook_id',session()->get('facebook_id'))->where('URL', $url)->first();
        $like_number=Like::where('URL', $url)->count();

        return view('pages.contest.photo')
            ->with('photo', $photo)
            ->with('like', $like)
            ->with('like_number', $like_number);
    }
}
