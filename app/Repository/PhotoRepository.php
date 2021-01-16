<?php


namespace App\Repository;

use App\Photo;

class PhotoRepository
{
    public function GetByContestIdFirstOrFail($contest,$request)
    {
        return Photo::where('contest_id',$contest->id)->where('id', $request->photo_id)->firstOrFail();
    }

    public function GetNextId($contest,$photo)
    {
        return Photo::where('contest_id',$contest->id)->where('id','>',$photo->id)->min('id');
    }

    public function GetPrevId($contest,$photo)
    {
        return Photo::where('contest_id',$contest->id)->where('id','<',$photo->id)->max('id');
    }
}
