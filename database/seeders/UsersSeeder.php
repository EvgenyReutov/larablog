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
        DB::table('users')->insert([
               'name'     => 'admin username',
               'email'    => 'admin@site.local',
               'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',//password
               'email_verified_at' => fake()->dateTime,
           ]);
        /*for ($i = 0; $i < 10; $i++) {
            $email = fake()->unique()->email();
            DB::table('users')->insert([
                       'name'     => fake()->name,
                       'email'    => $email,
                       'password' => Hash::make($email),
                       'email_verified_at' => fake()->dateTime,
                   ]);
        }*/
    }
}
