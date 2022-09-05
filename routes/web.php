<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/template', 'index', ['title' => 'Main Page1']);
Route::view('/main', 'main');
Route::view('/user', 'user');
Route::view('/register', 'register');
Route::view('/page', 'page');

