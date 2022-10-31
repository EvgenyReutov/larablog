<?php

namespace App\Repo\Post;

use App\DTO\PostDTO;
use App\Enums\PostStatus;
use App\Models\Post;

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

    public function all(): array
    {
        return Post::all()->map(PostDTO::fromModel(...))->all();
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
