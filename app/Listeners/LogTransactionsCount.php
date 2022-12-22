<?php

namespace App\Listeners;

use App\Events\TransactionCalcFinished;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogTransactionsCount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TransactionCalcFinished  $event
     * @return void
     */
    public function handle(TransactionCalcFinished $event)
    {
        app('log')->info("Transactions count proccessed = {$event->count}");
    }
}
