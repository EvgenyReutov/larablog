<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i +=2) {
            DB::table('posts')->insert([
               'author_id' => $i+1,
               'title'     => 'Post of '.$i,
               'slug' => 'code-'.$i,
               'text'      => 'Text of '.$i,
               'status'    => collect(['draft', 'active'])->random(),
           ]);
        }
    }
}
