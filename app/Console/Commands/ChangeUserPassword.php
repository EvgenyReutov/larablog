<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangeUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:password
     {userId : Id of the user}
     {password? : new user password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change user password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$password = $this->argument('password')) {
            $password = $this->secret('Enter new password');
            //$password = $this->ask('Enter new password');
        }

        if (!$this->confirm('Are you sure?')) {
            return;
        }

        User::find($this->argument('userId'))
            ->update([
                'password' => Hash::make($password)
                     ]);

        return Command::SUCCESS;
    }
}
