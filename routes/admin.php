<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::resource('/posts', \App\Http\Controllers\PostController::class)->middleware('auth');

Route::resource('/tags', \App\Http\Controllers\TagController::class);


Route::match([\Illuminate\Http\Request::METHOD_POST, \Illuminate\Http\Request::METHOD_GET],'/test', fn() => 'admin')
->name('test');

Route::get('/111', function (){

    return view('main', ['title' => 'Main Page', 'users' => ['John', 'Mary', 'Ivan']]);
})-> name('main');
