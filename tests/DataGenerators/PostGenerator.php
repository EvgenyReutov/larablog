<?php

namespace Tests\DataGenerators;

use App\Models\Post;
use App\Models\User;

trait PostGenerator
{
    public function generatePosts()
    {
        $author = User::factory()->create();
        $posts = [];

        for ($i = 0; $i < 10; $i ++) {
            $posts[] = Post::factory()->create(['author_id' => $author->id]);


        }

        return compact('author', 'posts');
    }
}
