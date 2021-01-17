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

                /*defined upload, web and thumbnail paths*/
                $path='storage/contest/'.$request->contest;
                $path_thumb=$path.'/thumb';
                $path_web=$path.'/web';

                /*Get contest details*/
                $contest=$this->contestRepository->galleryFirstOrFail($request->contest);

                /*Get user details*/
                $user=$this->userRepository->FirstOrFail(session()->get('facebook_id'));

                /*Get saved photo*/
                $photo=$request->photo->store($path);

                /*Check if thumb directory exist*/
                if (!file_exists($path_thumb)){
                    mkdir($path_thumb);
                }

                /*Check if web directory exist*/
                if (!file_exists($path_web)){
                    mkdir($path_web);
                }
                /*Get uploaded photo*/
                $resized=Image::make($photo);

                /*Define max sizes for web*/
                $width=1920;
                $height=1080;

                /*Compare actual size with defined*/
                if ($resized->width() < $width ) {$width=null;}
                if ($resized->height() < $height ) {$height=null;}

                /*If height or width is defined*/
                if($width || $height){
                    /*Resize and save for showing on the web*/
                    $resized->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                $resized->save($path.'/web/'.$resized->basename);

                /*resize and save for thumb*/
                $resized->resize(300, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $resized->save($path.'/thumb/'.$resized->basename);

                $path_web=$path_web.'/'.$resized->basename;
                $path_thumb=$path_thumb.'/'.$resized->basename;
                $this->photoRepository->Save($request->description,$user['id'],$contest->id,$photo,$path_web,$path_thumb);
                return back()->with('success','Súbor úspešne nahraný!');
            }
        }else{
                return back()->with('error','Nenahral si žiadny súbor!');}
            }
}
