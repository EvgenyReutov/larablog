<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel
{
    use HasFactory;

    protected $fillable = ['title', 'code'];

    public function posts()
    {
        return $this->belongsToMany(Post::class)->using(PostTag::class);
    }

    static function getCacheKey(): string
    {
        return 'tags';
    }
}
