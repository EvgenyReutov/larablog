<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;




Route::match([\Illuminate\Http\Request::METHOD_POST, \Illuminate\Http\Request::METHOD_GET],'/test', fn() => 'admin')
->name('test');

Route::get('/111', function (){

    return view('main', ['title' => 'Main Page', 'users' => ['John', 'Mary', 'Ivan']]);
})-> name('main');


Route::resource('/tags', \App\Http\Controllers\Admin\AdminTagController::class);

Route::resource('/posts', \App\Http\Controllers\Admin\AdminPostController::class)
    //->middleware('auth')
;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    //->middleware('auth')
    ->name('admin_home');
