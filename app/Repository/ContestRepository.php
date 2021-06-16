<?php

namespace App\Repository;

use App\Contest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * Get list of active contests
     * @return Collection
     */
    public function getAllActiveContests(): Collection
    {
        return Contest::where('stop_vote', '>' , Carbon::now())->get();
   }
}
