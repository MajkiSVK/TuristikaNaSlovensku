<?php


namespace App\Services;


use App\Http\Requests\ContestPhotoRequest;
use App\Repository\ContestRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Resize and save uploaded photo with all important information
     * @param ContestPhotoRequest $request
     * @return RedirectResponse
     */
    public function savePhoto(ContestPhotoRequest $request): RedirectResponse
    {
                /*defined upload, web and thumbnail paths*/
                $path='storage/contest/'.$request->contest;
                $path_thumb=$path.'/thumb';
                $path_web=$path.'/web';

                /*Get details for contest and store original photo*/
                $contest=$this->contestRepository->getContestBySlug($request->contest);
                $user=$this->userService->getLoggedInUserData();
                $photo=$request->photo->store($path);

                /*Create directories, if missing */
                if (!file_exists($path_thumb)){
                    mkdir($path_thumb);
                }
                if (!file_exists($path_web)){
                    mkdir($path_web);
                }

                /*Resize photo and store all information to the database*/
                $resized=$this->photo_resize($photo,$path_web,'1920','1080');
                $this->photo_resize($photo,$path_thumb,'300','150');
                $path_web=$path_web.'/'.$resized->basename;
                $path_thumb=$path_thumb.'/'.$resized->basename;
                $this->photoRepository->Save($request->description,$user['id'],$contest->id,$photo,$path_web,$path_thumb);

                return back()->with('success','Súbor úspešne nahraný!');
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

