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


Route::get('/template', function (){
    App::setLocale(request()->get('locale'));
    return view('index', ['title' => 'Main Page1', 'users' => ['John', 'Mary', 'Ivan']]);
});
//Route::view('/template', 'index', ['title' => 'Main Page1', 'users' => ['John', 'Mary', 'Ivan']]);

Route::get('/', function (){

    return view('main', ['title' => 'Main Page', 'users' => ['John', 'Mary', 'Ivan']]);
})-> name('main');

Route::get('/user', function (){

    return view('user', ['title' => 'Страница пользователя']);
})-> name('user');

Route::get('/register', function (){

    return view('register', ['title' => 'Регистрация']);
})-> name('register');

Route::get('/contacts', function (){

    return view('contacts', ['title' => 'Контакты']);
})-> name('contacts');
Route::view('/page', 'page');

//Route::view('/main', 'main');



