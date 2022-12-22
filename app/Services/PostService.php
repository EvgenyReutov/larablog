<?php

namespace App\Services;

use App\DTO\PostDTO;
use App\Jobs\HandlePostCreated;
use App\Models\Post;
use App\Services\Notification\NotificationService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class PostService
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public function create(PostDTO $postDTO): Post
    {
        $arr = $postDTO->toEloquentArray();

        $post = Post::create($arr);
        $text = "User with id = ".$postDTO->author->id." has created a post with id = ".$post->id;
        if (count($arr['tags'])) {
            $post->tags()->attach($arr['tags']);

        }
        //чистим кеш
        Cache::tags(['post_list', 'post_list_nav'])->flush();

        //dump($this->notificationService);
        //dump(App::make(NotificationService::class));
        //dd(app(NotificationService::class));

        $this->notificationService->notify(1, $text);

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
