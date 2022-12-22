<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends BaseModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = ['author_id', 'slug', 'title', 'text', 'status'];
    protected $hidden = ['text'];
    protected $casts = [
        'status' => PostStatus::class,
        'metadata' => 'array',
    ];
    protected $with = ['comments'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function commentLikes()
    {
        return $this->hasManyThrough(CommentLike::class, Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->using(PostTag::class);
    }

    static function getCacheKey(string $id = '', int $currentPage = 1): string
    {
        return 'posts' . ($id ? '_' . $id : '') . ' ' . $currentPage;
    }

    /*public function resolveRouteBinding($value, $searchParamName = null)
    {
        dump($value);
        dump($searchParamName);
        return Post::query()->where(
            $searchParamName ?? $this->getRouteKeyName(),
            $value)->first();
    }

    public function getRouteKeyName()
    {
        return 'author_id';
    }*/
}
