<?php


namespace App\Repository;

use App\Photo;

class PhotoRepository
{
    /**
     * Get the photo with Contest_id and photo ID
     * @param int $contest_id
     * @param int $photo_id
     * @return Photo
     */
    public function GetPhotoByContestIdFirstOrFail(int $contest_id,int $photo_id): Photo
    {
        return Photo::where('contest_id',$contest_id)->where('id', $photo_id)->firstOrFail();
    }

    /*
     * Get next photo ID
     */
    public function GetNextId($contest,$photo)
    {
        return Photo::where('contest_id',$contest->id)->where('id','>',$photo->id)->min('id');
    }

    /*
     * Get previous photo ID
     */
    public function GetPrevId($contest,$photo)
    {
        return Photo::where('contest_id',$contest->id)->where('id','<',$photo->id)->max('id');
    }

    /*
     * Save the photo information
     */
    public function Save($description,$user_id,$contest_id,$original_path,$resized_path,$thumb_path)
    {
        $photo=new Photo();
        $photo->description = $description;
        $photo->user_id=$user_id;
        $photo->contest_id=$contest_id;
        $photo->original_path=$original_path;
        $photo->resized_path=$resized_path;
        $photo->thumb_path=$thumb_path;

        return $photo->save();
    }
}
