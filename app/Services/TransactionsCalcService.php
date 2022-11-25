<?php

namespace App\Services;

use \Illuminate\Database\Eloquent\Collection;

class TransactionsCalcService
{
    public function calc(Collection $transactions): array
    {
        sleep(3);
        return $transactions->groupBy('user_id')
            ->map(function (Collection $userTransactions){
                return [
                    $userTransactions->first()->user_id,
                    $userTransactions->map->amount->sum()
                ];
            })
            ->values()
            ->toArray()
        ;

    }
}
