<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetUserAge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:age';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set age only for 5 users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $headers = ['ID', 'Email'];
        $usersSet = User::all('id', 'email');
        $users = $usersSet->toArray();

        $this->table($headers, $users);


        $bar = $this->output->createProgressBar(count($users));
        $bar->start();
        foreach ($usersSet as $user) {

            sleep(1);
            dump($user->email);
            $bar->advance();
        }


        $bar->finish();
        $availableUserIds = User::take(5)->get(['id','email'])->pluck('email','id')->toArray();

        $this->info(PHP_EOL . 'info line');

        $userIds = $this->choice('Enter userId', $availableUserIds);

        $age = $this->anticipate('Write age', ["18", "22"]);

        dd($age);

        return Command::SUCCESS;
    }
}
