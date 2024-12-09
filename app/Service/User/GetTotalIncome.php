<?php

namespace App\Service\User;

use App\Models\Boost;
use App\Models\BoostUsers;

class GetTotalIncome
{
    public function execute(int $userId)
    {
        $boosts = Boost::all();
        $boost_users = BoostUsers::where('user_id', $userId)
            ->get()
            ->keyBy('boost_id')
            ->toArray();

        $total_income = 0;
        foreach ($boosts as $boost) {
            if (isset($boost_users[$boost->id])) {
                $total_income += $boost->lvl_prices[$boost_users[$boost->id]['lvl'] - 1]['income_per_hour'];
            }
        }
        return $total_income;
    }
}