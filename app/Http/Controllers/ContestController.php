<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function gallery(Request $request)
    {
        $images=['0'=>'public/storage/contest/test_image.jpg',
                 '1'=>'public/storage/contest/test_image2.jpg',
                 '2'=>'public/storage/contest/test_image2.jpg',
                 '3'=>'public/storage/contest/test_image.jpg',
                 '4'=>'public/storage/contest/test_image2.jpg',
                 '5'=>'public/storage/contest/test_image3.jpg',
                 '6'=>'public/storage/contest/test_image.jpg',
                 '7'=>'public/storage/contest/test_image2.jpg'];
        return view('pages.contest.gallery')
                ->with('images',$images)
                ->with('name', $request->contest);
    }
}
