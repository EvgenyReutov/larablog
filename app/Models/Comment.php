<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends BaseModel
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = ['post_id', 'author_id', 'text'];
}
