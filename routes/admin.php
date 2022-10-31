<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::resource('/posts', \App\Http\Controllers\PostController::class);

Route::resource('/tags', \App\Http\Controllers\TagController::class);

