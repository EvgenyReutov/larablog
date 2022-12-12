<?php

namespace App\Repo\Post;

use App\DTO\PostDTO;
use App\Enums\PostStatus;

interface PostRepo
{
    public function findById($id): PostDTO;

    public function findBy($argument, $value): PostDTO;

    public function all(): array;

    public function paginate(int $count);

    public function getAllByStatus(PostStatus $status): array;

    public function getAllActive(): array;
}
