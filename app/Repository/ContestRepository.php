<?php


namespace App\Repository;


use App\Contest;

class ContestRepository
{
    /*
     * Get contest information If exists
     */
    public function galleryFirstOrFail($contest)
    {
        return Contest::where('slug', $contest)->firstOrFail();
   }
}
