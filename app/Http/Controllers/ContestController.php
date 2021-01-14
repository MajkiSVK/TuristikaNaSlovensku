<?php

namespace App\Http\Controllers;

use App\Contest;
use App\Photo;
use App\User;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    /*
     * Show gallery page
     */
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

    /*
     * Show photo page
     */
    public function photo(Request $request)
    {
        $photo=['URL'=>'public/storage/contest/test_image.jpg',
                'Author'=>'Tomáš Majki Miki Mikuláš',
                'Description'=>'Fotené u tvojej mamy doma na záhrade keď tancovala',
                ];

        return view('pages.contest.photo')
            ->with('request',$request)
            ->with('photo', $photo);
    }

    public function testovaci(Request $request)
    {
        if ($request->id==='1'){

            $user=User::firstOrFail();


            return $user->delete();
        }

        if ($request->id==='2'){

            $photo=Photo::FirstOrFail();
            $contest=Contest::FirstOrFail();
            $contest->photos()->detach($photo);
            return 'detech done';
        }

        if ($request->id==='3'){


            $contest=Contest::FirstOrFail();
            $contest->delete();
            return 'delete done';
        }

    }
}
