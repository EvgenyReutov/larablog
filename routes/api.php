<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ShowPostApiV2Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:user_token')->get('/user', function (Request $request) {
    return $request->user('user_token');
});

function apiRoutesV1(Router $router) {
    $router->apiResource('posts', PostController::class);
}

Route::group(['prefix' => 'v1', 'middleware' => 'auth:jwt'], apiRoutesV1(...));

function apiRoutesV2(Router $router) {
    apiRoutesV1($router);

    $router->get('/posts/{post}', ShowPostApiV2Controller::class);
    $router->get('/hello', fn() => 'hi there');
}

Route::group(['prefix' => 'v2'], apiRoutesV2(...));

Route::post('/login', LoginController::class);

Route::get('/posts/my', function (){
    $user = auth()->user();


    $posts = Post::where('author_id', $user->id)->get();

    return PostResource::collection($posts);

})->middleware('auth:jwt');

Route::get('/posts/me', function (){
    $user = auth()->user();

    return $user;

})->middleware('auth:jwt');

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
