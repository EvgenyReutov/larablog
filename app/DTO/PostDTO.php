<?php

namespace App\DTO;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;

class PostDTO implements Arrayable {

    public function __construct(
        public int|null $id,
        public string $title,
        public $slug,
        public string $text,
        public $author,
        public $tags,
        public $created_at,
        public PostStatus $status)
    {

    }

    public function getTitle()
    {
        return $this->title;
    }

    public static function fromModel(Post $post): self
    {
        return new static(
            $post->id, $post->title, $post->slug, $post->text,
            $post->author,
            $post->tags(),
            $post->created_at,
            $post->status
        );
    }

    public static function fromRequest(Request $request): static
    {
        $author = User::find($request->author_id);

        return new static(
            null, $request->title, $request->slug, $request->text,
            $author,
            $request->tags,
            null,
            PostStatus::from($request->status)
        );
    }

    public function toEloquentArray(): array
    {

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'text' => $this->text,
            'author_id' => $this->author->id,
            'author' => $this->author,
            'status' => $this->status,
            'tags' => $this->tags,
            //'title' => $this->title,
        ];
    }


    public function toArray()
    {

        return [
            'data' => [
                'id' => $this->id,
                'title' => $this->title,
                'status' => $this->status,
                'author_id' => $this->author->id,
            ]
        ];
    }
}
