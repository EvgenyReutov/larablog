<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::match([\Illuminate\Http\Request::METHOD_POST, \Illuminate\Http\Request::METHOD_GET],'/test', fn() => 'admin');

Route::get('/111', function (){

    return view('main', ['title' => 'Main Page', 'users' => ['John', 'Mary', 'Ivan']]);
})-> name('main');
