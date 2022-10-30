<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

//*********

Route::get('/qb/', function (){

    $users = DB::table('users')
        //->where('name', 'LIKE', 'Ryley Gorczany')
        //->whereBetween('id', [1,5])
        ->whereRaw('id BETWEEN ? and ?', [1,5])
        //->toSql()
        //->limit(3)->offset(3)
        ->get()
    ;

    dump($users);

    return $users;
});


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

Route::get('/like/{commentLike}', function(\App\Models\CommentLike $commentLike){
    //dump($commentLike);
    dump($commentLike->post);
    return 'ok';
});


/*Route::controller(\App\Http\Controllers\PostController::class)->group(function (){
    Route::get('/post/{id}', 'show')->name('post');
});*/

Route::prefix('gg')->group(function(){
    Route::controller(\App\Http\Controllers\PostController::class)->group(function (){
        Route::get('/post/{id}', 'show')->name('post');
    });
});

Route::resource('/data/profile/posts', \App\Http\Controllers\PostController::class)
->except('destroy', 'store');

Route::resource('/posts', \App\Http\Controllers\PostController::class);

Route::get('/pp/{post}', [\App\Http\Controllers\PostController::class, 'withoutRepo'])
->missing(function (){
    //return redirect('/');
    return response('not found');
});
//Route::get('/pp/{post:author_id}', [\App\Http\Controllers\PostController::class, 'withoutRepo']);


Route::get('/calc/{post}/{b?}', fn(\App\Models\Post $post, $x2 = 0) => $post)
->where(['b' => '[123]']);

Route::view('/calc/', 'form');
Route::post('/calculate/', function (\Illuminate\Http\Request $request){
    $x1 = (int)$request->x1;
    $x2 = (int)$request->x2;

    return $x1+$x2;
})->name('calculate');

Route::get('/post/status/{status}', function(\App\Enums\PostStatus $status, \App\Repo\Post\PostRepo $postEloquentRepo){

    $data = $postEloquentRepo->getAllByStatus($status);

    dump($data);
    return 'ok';
});

/*Route::get('/post/{id}', function(int $postId, \App\Repo\Post\PostRepo $postEloquentRepo)
{

    $post = $postEloquentRepo->findById($postId);
    //$post =  \App\Models\Post::find($postId);
    //dump($post->commentLikes);
    //dump($post->author);
    dump($post);
    return 'ok';
})->name('post');*/

Route::get('/update-post/{post}', function (\App\Models\Post $post){
    $post->delete();
    //$post->text = 'changed text';
    //$post->save();
    dump($post);


    return 'ok';
});
Route::get('/create-post', function (){
    $post = new \App\Models\Post();
    $post->title = 'Post title3';
    $post->author_id = 2;
    $post->slug = 'test3';
    $post->text = 'test3';
    $post->status = \App\Enums\PostStatus::Draft;
    $post->save();

    /*$postData = request()->only('title', 'author_id', 'slug', 'text');
    dump($postData);
    \App\Models\Post::create($postData);*/


    return 'ok';
});

Route::get('/posts2', function (){
    $posts = \App\Models\Post::all();
    $tags = \App\Models\Tag::all();
    dump($tags);
    //$posts = \App\Models\Post::with(['author', 'comments'])->get();
    //$posts = \App\Models\Post::query()->whereRaw()->join()->where()->select()->get();
    /*

    $postData = \App\Models\Post::query()
        ->join('users', 'users.id', '=', 'posts.author_id')
        ->select('posts.id', 'posts.status', 'users.id as user_id', 'users.name')
        ->get();

    dd($postData[0]->status);

    foreach ($posts as $post) {
        dump($post->author->name);
        //dump($post->comments->map(
        //    function ($comment){
        //    return ['text' => $comment->text];
       //     }
        //));
        dump($post->comments->map(fn($comment) => $comment->text));

    }

    dump($posts);
    */
    return 'ok';
});

Route::get('/i', \App\Http\Controllers\PostShow::class);

Route::get('/csrf', fn () => csrf_token());

Route::fallback(function (){
    return 'ok fallback';
});

