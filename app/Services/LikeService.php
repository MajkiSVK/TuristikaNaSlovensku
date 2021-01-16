<?php


namespace App\Services;


use App\Repository\LikeRepository;

class LikeService
{

    private $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {

        $this->likeRepository = $likeRepository;
    }

    /*
     * Add like, if the user is logged in and not voted yet.
     */
    public function add_like($facebook_id,$url)
    {
        /*Check if a user already voted for this photo*/
        $check_like=$this->likeRepository->check_like($facebook_id,$url);

        /*Return back, if user alredy voted*/
        if (!empty($check_like)){
            return back()->with('error','Za túto fotku už si hlasoval! Nemôžeš hlasovať viac krát');
        }

        /*Check if the user is logged in*/
        if ($facebook_id){
            $this->likeRepository->add_like($facebook_id,$url);
            return back();
        }else{
            return back()->with('error','Pre hlasovanie sa musíš prihlásiť');
        }
    }

}

