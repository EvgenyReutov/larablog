<?php

use App\Http\Controllers\PostController;
use App\Jobs\CalcTransactions;
use App\Models\User;
use App\Models\UserTransaction;
use App\Services\TransactionsCalcService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

Route::get('/contacts', function (){

    return view('contacts', ['title' => 'Контакты']);
})-> name('contacts');


Route::resource('/posts', PostController::class)
    ->except('destroy', 'store', 'update', 'edit', 'create');

Route::get('/posts/tag/{tag}', [PostController::class, 'index'])
    ->missing(function (){
        //return redirect('/');
        return response('not found');
    })->name('list_by_tag');

Route::get('/', [PostController::class, 'index'])-> name('main');

Route::get('/error', function (){

    throw new \Exception('test exception');
});

Auth::routes();


