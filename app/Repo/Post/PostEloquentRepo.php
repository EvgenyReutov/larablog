<?php

namespace App\Repo\Post;

use App\DTO\PostDTO;
use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\Tag;
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
        //$store = Cache::store()->getStore();
        //dump($store);
        //$posts = Post::get();
        //dd($posts);
        $posts = Cache::tags('post_list')
            ->remember(Post::getCacheKey(), 3600, function(){
                //dump('cache miss');
                return Post::get();
            });
        //dump('from cache');
        return $posts->map(PostDTO::fromModel(...))->all();
    }

    public function paginate(int $count, string $tag = '')
    {
        $posts = Cache::tags('post_list')
            ->remember(Post::getCacheKey($tag), 3600, function() use ($count, $tag) {
                //dump('cache miss');

                if($tag){
                    $tagModel = Tag::query()->where('code', $tag)->first();
                    //dd($tag);


                    $posts = $tagModel->posts()->paginate($count);
                } else {
                    $posts = Post::paginate($count);
                }

                return $posts;
                //return Post::get();
            });

        return $posts;
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
