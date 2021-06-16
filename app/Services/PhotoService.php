<?php


namespace App\Services;


use App\Repository\ContestRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use Intervention\Image\Facades\Image;

class PhotoService
{
    private $photoRepository;
    private $contestRepository;
    private $userRepository;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(PhotoRepository $photoRepository,
                                ContestRepository $contestRepository,
                                UserRepository $userRepository,
                                UserService $userService)
    {

        $this->photoRepository = $photoRepository;
        $this->contestRepository = $contestRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }
    /*
     * Get Photo info with Next and Prev IDs
     */
    public function GetPhotoWithNextPrev($request)
    {
        $contest=$this->contestRepository->getBySlug($request);
        $photo=$this->photoRepository->GetByContestIdFirstOrFail($contest,$request);
        $next= $this->photoRepository->GetNextId($contest,$photo);
        $prev= $this->photoRepository->GetPrevId($contest,$photo);
        $photo->setRelation('next',$next);
        $photo->SetRelation('prev',$prev);
        return $photo;
    }

    /*
     * Save uploaded photo
     */
    public function savePhoto($request)
    {
        /*Check if file is uploaded*/
        if ($request->hasFile('photo')){

            /*check if description is written*/
            if (empty($request->description)){
                return back()->with('error','Nezadal si žiadny popis fotky!');
            }

            /*check if file is valid*/
            if ($request->file('photo')->isValid()){
                $request->validate([
                    'description'=>'string|max:100',
                    'photo'=>'mimes:jpg,jpeg,png'
                ]);

                /*defined upload, web and thumbnail paths*/
                $path='storage/contest/'.$request->contest;
                $path_thumb=$path.'/thumb';
                $path_web=$path.'/web';

                /*Get contest details*/
                $contest=$this->contestRepository->getContestBySlug($request->contest);

                /*Get user details*/
                $user=$this->userService->getLoggedInUserData();

                /*Save original photo and make "path" variable */
                $photo=$request->photo->store($path);

                /*Make thumb directory, if he is not existing*/
                if (!file_exists($path_thumb)){
                    mkdir($path_thumb);
                }

                /*Make web directory, if he is not existing*/
                if (!file_exists($path_web)){
                    mkdir($path_web);
                }

                /*Resize photo for web page */
                $resized=$this->photo_resize($photo,$path_web,'1920','1080');

                /*resize and save for thumb*/
                $this->photo_resize($photo,$path_thumb,'300','150');

                /*Define photo paths for database*/
                $path_web=$path_web.'/'.$resized->basename;
                $path_thumb=$path_thumb.'/'.$resized->basename;
                $this->photoRepository->Save($request->description,$user['id'],$contest->id,$photo,$path_web,$path_thumb);
                return back()->with('success','Súbor úspešne nahraný!');
            }
        }else{
            return back()->with('error','Nenahral si žiadny súbor!');}
    }


    /*
     * Resize photo with specific parameters
     */
    public function photo_resize($photo,$path,$width,$height)
    {
        $resized=Image::make($photo);

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
        /*save photo to defined path*/
      return $resized->save($path.'/'.$resized->basename);
    }

}

