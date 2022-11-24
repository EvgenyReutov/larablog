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

/*
Route::group(
    [
        'prefix' => '{locale}',
        'where' => ['locale' => '[a-zA-Z]{2}'],
        'middleware' => 'checkLocale'
    ],function() {

    Route::resource('/posts', \App\Http\Controllers\PostController::class)
        ->except('destroy', 'store', 'update', 'edit', 'create');
});
*/
Route::resource('/posts', \App\Http\Controllers\PostController::class)
    ->except('destroy', 'store', 'update', 'edit', 'create');






Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


