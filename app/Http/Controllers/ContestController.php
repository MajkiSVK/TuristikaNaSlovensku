<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Like;
use App\Photo;
use App\Repository\ContestRepository;
use App\User;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    private $contestRepository;

    public function __construct(ContestRepository $contestRepository)
    {

        $this->contestRepository = $contestRepository;
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
        $contest=Contest::where('slug', $request->contest)->FirstOrFail();
        $photo=Photo::where('contest_id',$contest->id)->where('id', $request->photo_id)->firstOrFail();
        $next= Photo::where('contest_id',$contest->id)->where('id','>',$photo->id)->min('id');
        $prev= Photo::where('contest_id',$contest->id)->where('id','<',$photo->id)->max('id');
        $url=$request->contest.'/'.$photo->id;
        /*Check if a user already voted for this photo*/
        $like=Like::where('facebook_id',session()->get('facebook_id'))->where('URL', $url)->first();
        $like_number=Like::where('URL', $url)->count();

        return view('pages.contest.photo')
            ->with('photo', $photo)
            ->with('next_id', $next)
            ->with('prev_id',$prev)
            ->with('like', $like)
            ->with('like_number', $like_number);
    }
}
