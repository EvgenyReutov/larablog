<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = \App\Models\Post::all();
        $tags = \App\Models\Tag::all();

        foreach ($posts as $post) {

            $id = $tags->random()->toArray()['id'];
            DB::table('post_tag')->insert([
                'post_id' => $post->id,
                'tag_id'  => $id,
            ]);
            DB::table('post_tag')->insert([
                'post_id' => $post->id,
                'tag_id'  => $tags->where('id', '!=', $id)->random()->toArray()['id'],
            ]);
        }
    }
}
