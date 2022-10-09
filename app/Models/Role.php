<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    }

}
