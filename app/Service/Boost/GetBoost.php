<?php

namespace App\Service\Boost;

use App\Models\Boost;
use App\Models\BoostUsers;

class GetBoost
{
    public function execute(int $userId)
    {
        $boosts = Boost::all();
        $boosts->each(function ($boost) use ($userId) {
            $boost->max_lvl = $boost->getBoostMaxLvl();
        });

        return $boosts;
    }
}