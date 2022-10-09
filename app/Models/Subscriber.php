<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends BaseModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = ['email'];
}
