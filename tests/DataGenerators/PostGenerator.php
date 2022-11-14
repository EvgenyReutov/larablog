<?php

namespace Tests\DataGenerators;

use App\Models\Post;
use App\Models\User;

trait PostGenerator
{
    public function generatePosts($count = 10)
    {
        $author = User::factory()->create();
        $posts = [];

        for ($i = 0; $i < $count; $i ++) {
            $posts[] = Post::factory()->create(['author_id' => $author->id]);
        }

        return compact('posts');
    }
}
