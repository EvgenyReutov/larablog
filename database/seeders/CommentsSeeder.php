<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $j = 0;
        for ($i = 0; $i < 10; $i +=2) {
            $j++;
            DB::table('comments')->insert([
               'author_id' => $i+1,
               'post_id' => $j,
               'text'      => 'comment Text of '.$j,
           ]);
        }
    }
}
