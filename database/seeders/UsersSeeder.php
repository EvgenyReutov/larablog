<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $email = fake()->unique()->email();
            DB::table('users')->insert([
                       'name'     => fake()->name,
                       'email'    => $email,
                       'password' => Hash::make($email),
                       'email_verified_at' => fake()->dateTime,
                   ]);
        }
    }
}
