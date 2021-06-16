<?php

namespace App\Repository;

use App\Contest;
use Carbon\Carbon;

class ContestRepository
{
    /**
     * Get contest data by slug, if exists
     * @param string $slug
     * @return Contest
     */
    public function getContestBySlug(string $slug): Contest
    {
        return Contest::where('slug', $slug)->firstOrFail();
   }

    public function getAllActiveContests()
    {
        return Contest::where('stop_vote', '>' , Carbon::now())->get();
   }
}
