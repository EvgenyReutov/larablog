<?php

namespace App\Repo\Post;

use App\DTO\PostDTO;
use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PostEloquentRepo implements PostRepo
{
    public function findById($id): PostDTO
    {
        $data = Post::find($id);
        return PostDTO::fromModel($data);
    }

    public function findBy($argument, $value): PostDTO
    {
        return PostDTO::fromModel(Post::query()->where($argument, $value)->first());
    }

    /*public function getList(): Collection
    {
        $posts = Cache::tags('post_list')
            ->remember(Post::getCacheKey(), 600, function(){
                return Post::get();
            });

        return $posts;
    }*/

    public function all(): array
    {
        //$posts = $this->getList();
        $posts = Cache::tags('post_list')
            ->remember(Post::getCacheKey(), 600, function(){
                return Post::get();
            });
        return $posts->map(PostDTO::fromModel(...))->all();
    }

    public function getAllByStatus(PostStatus $status): array
    {
        $f = PostDTO::fromModel(...);
        return Post::query()->where('status', $status)->get()->map($f)->all();
    }

    public function getAllActive(): array
    {
        return $this->getAllByStatus(PostStatus::Active);
    }
}
