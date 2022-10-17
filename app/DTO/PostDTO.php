<?php

namespace App\DTO;

use App\Enums\PostStatus;
use App\Models\Post;

class PostDTO {

    public function __construct(
        public int $id,
        public string $title,
        public PostStatus $status)
    {

    }

    public function getTitle()
    {
        return $this->title;
    }

    public static function fromModel(Post $post): self
    {
        return new static($post->id, $post->title, $post->status);
    }

    /*public function __invoke(...$args)
    {
        return $args;
    }*/
}
