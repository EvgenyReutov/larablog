<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;



Route::resource('/tags', \App\Http\Controllers\Admin\AdminTagController::class);

Route::resource('/posts', \App\Http\Controllers\Admin\AdminPostController::class)
    //->middleware('auth')
;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    //->middleware('auth')
    ->name('admin_home');
