<?php

namespace App\Jobs;

use App\Events\TransactionCalcFinished;
use App\Models\UserTransaction;
use App\Services\TransactionsCalcService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class CalcTransactions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 4;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected array $transactionsIds)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TransactionsCalcService $transactionsCalcService)
    {
        $trs = UserTransaction::whereIn('id', $this->transactionsIds)->get();
        $res = $transactionsCalcService->calc($trs);

        TransactionCalcFinished::dispatch(count($res));

        app('log')->info('Transactions calc result', ['res' => $res]);
    }

    //public function middleware()
    //{
        //return [new WithoutOverlapping($this->user->id)];
    //}

    public function failed(\Throwable $exception)
    {
        //send user notification
        app('log')->info('Transactions calc failed', ['exception' => $exception->getMessage()]);
    }
}
