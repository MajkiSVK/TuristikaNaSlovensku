<?php


namespace App\Services;


use App\Repository\ContestRepository;
use App\Repository\PhotoRepository;

class PhotoService
{

    private $photoRepository;
    private $contestRepository;

    public function __construct(PhotoRepository $photoRepository,
                                ContestRepository $contestRepository)
    {

        $this->photoRepository = $photoRepository;
        $this->contestRepository = $contestRepository;
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
}

