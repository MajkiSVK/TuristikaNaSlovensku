<?php

namespace App\Services;

use App\Repository\LikeRepository;
use Illuminate\Http\RedirectResponse;

class LikeService
{
    /**
     * @var LikeRepository
     */
    private $likeRepository;

    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    /**
     * Add like, if the user is logged in and not voted yet.
     * @param int $facebook_id
     * @param string $url
     * @return RedirectResponse
     */
    public function add_like(int $facebook_id,string $url): RedirectResponse
    {
        /*Check if a user already voted for this photo*/
        $check_like = $this->likeRepository->check_like($facebook_id,$url);

        /*Return back, if user alredy voted*/
        if (!empty($check_like)){
            return back()
                ->with('error','Za túto fotku už si hlasoval! Nemôžeš hlasovať viac krát');
        }

        /*Check if the user is logged in*/
        if (!$facebook_id){
            return back()
                ->with('error','Pre hlasovanie sa musíš prihlásiť');
        }

        $this->likeRepository->add_like($facebook_id,$url);
        return back();
    }

}

