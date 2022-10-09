<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends BaseModel
{
    use HasFactory;

    public function post()
    {
        return $this->hasOneThrough(
            Post::class, Comment::class,
            'id',
            'id',
            '',
            'post_id'
        );
    }
}
