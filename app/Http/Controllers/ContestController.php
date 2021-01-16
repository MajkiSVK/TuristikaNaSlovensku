<?php

namespace App\Http\Controllers;

use App\Repository\ContestRepository;
use App\Repository\LikeRepository;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


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
        /*Check if file is uploaded*/
        if ($request->hasFile('photo')){

            /*check if description is written*/
            if (empty($request->description)){
                return back()->with('error','Nezadal si žiadny popis fotky!');
            }

            /*check if file is valid*/
            if ($request->file('photo')->isValid()){
                $validated=$request->validate([
                    'description'=>'string|max:100',
                    'photo'=>'mimes:jpg,jpeg,png'
                ]);

                /*defined upload path*/
                $path='storage/contest/'.$request->contest;

                $request->photo->store($path);

                return back()->with('success','Súbor úspešne nahraný!');
            }
        }else{
                return back()->with('error','Nenahral si žiadny súbor!');}
            }
}
