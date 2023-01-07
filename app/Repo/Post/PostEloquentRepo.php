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
//dump($data);
//dd($id);
        return PostDTO::fromModel($data);
    }

    public function findBy($argument, $value): PostDTO
    {
        $post = Post::query()->where($argument, $value)->first();
        if(!$post){
            return abort(404);
        }
        return PostDTO::fromModel($post);
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
                return Post::query()->orderBy('id','DESC')->get();
            });
        //dump('from cache');
        return $posts->map(PostDTO::fromModel(...))->all();
    }

    public function paginate(int $count, string $tag = '')
    {
        $currentPage = request()->get('page', 1);

        $posts = Cache::tags('post_list_nav')
            ->remember(Post::getCacheKey($tag, $currentPage), 3600, function() use ($count, $tag) {
                //dump('cache miss');

                if($tag){
                    $tagModel = Tag::query()->where('code', $tag)->first();
                    //dd($tag);


                    $posts = $tagModel->posts()->orderBy('id','DESC')->paginate($count);
                } else {
                    $posts = Post::orderBy('id','DESC')->paginate($count);
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
