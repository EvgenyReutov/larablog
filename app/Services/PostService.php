<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Jobs\HandlePostCreated;
use App\Models\Post;

class PostService
{
    public function create(PostDTO $postDTO): Post
    {
        $arr = $postDTO->toEloquentArray();

        $post = Post::create($arr);
        $job = new HandlePostCreated($post);

        dispatch($job);

        return $post;
    }

    public function update(int $postId, PostDTO $postDTO): bool
    {
        $post = Post::find($postId);
        $arr = $postDTO->toEloquentArray();
        //dd($arr);
        return $post->update($postDTO->toEloquentArray());
    }
}
