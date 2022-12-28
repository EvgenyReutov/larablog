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

//========================================================================


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


/*Route::get('/', function (){
    //dd(Auth::check());
    return view('main', ['title' => 'Main Page', 'users' => ['John', 'Mary', 'Ivan']]);
})-> name('main');*/

Route::get('/user', function (){

    return view('user', ['title' => 'Страница пользователя']);
})-> name('user');

/*Route::get('/register', function (){

    return view('register', ['title' => 'Регистрация']);
})-> name('register');*/





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
    Route::controller(PostController::class)->group(function (){
        Route::get('/post/{id}', 'show')->name('post');
    });
});

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




Route::get('/pp/{post}', [PostController::class, 'withoutRepo'])
->missing(function (){
    //return redirect('/');
    return response('not found');
});
//Route::get('/pp/{post:author_id}', [\App\Http\Controllers\PostController::class, 'withoutRepo']);

Route::get('/int', function (){


    return app('myint');
})->name('myint');

Route::get('/calc/{post}/{b?}', fn(\App\Models\Post $post, $x2 = 0) => $post)
->where(['b' => '[123]']);

Route::view('/calc/', 'form');
Route::post('/calculate/', function (Request $request){
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

Route::get('/r', function (){
    if (\Illuminate\Support\Facades\Gate::allows(\App\Providers\AuthServiceProvider::ADMINS)) {
        dump(Route::current());
        dd(\route('qqq'));
    } else {
        return 403;
    }


    return 'ok';
})->name('qqq')->middleware('auth');

/*Route::get('/r')->setAction([
    'uses' => function() {
        dump(Route::current());
        dd(\route('qqq'));
    },
    'http'
])->name('qqq')->middleware('auth');*/

Route::get('/i', \App\Http\Controllers\PostShow::class);

Route::get('/csrf', fn () => csrf_token());

Route::fallback(function (){
    return 'ok fallback';
});


Auth::routes();

Route::get('/json', fn() => [
    'status' => 'ok',
    'data' => [
        'posts' => [
            ['id' => 1, 'title' => 'post1'],
            ['id' => 2, 'title' => 'post2'],
        ]
    ]
]);


Route::get('/log', function () {

    $userId = 3;
    $request = request();
    \Illuminate\Support\Facades\Log::channel('syslog')->emergency('user logged in', compact('userId', 'request'));
    //\Illuminate\Support\Facades\Log::info('user logged in', compact('userId', 'request'));

    return 'ok1';
});


Route::get('/collect', function () {

    User::factory(5)->make()
        ->dump()
        ->filter(fn($u) => $u->age > 25)
        ->dump()
        ->map(fn($u) => $u->name)
        ->dd()
    ;

    return 'ok1';
});

Route::get('/lazy', function () {

    ini_set('memory_limit', '2M');
    var_dump(memory_get_usage());
    //phpinfo();
    //$users = \App\Models\User::all();

    //$users = \App\Models\User::Lazy();//->filter(fn ($u) => $u->id % 2 === 0);
    //$users = \App\Models\User::Lazy()->filter(fn ($u) => $u->id % 2 === 0);
    $users = User::chunk(100, fn ($u) => $u->map->name);
    //dump($users->count());
    dump($users->count());

    return 'ok2';
});


Route::get('/exception', function () {

    throw new \Exception('my_custom_wrong_event');

    return 'ok';
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])
        ->name('users.show')
        ->middleware(
            [
                'age',
                'checkCountry'
            ])
    ;
    Route::get('/users_ru', [\App\Http\Controllers\UserController::class, 'index'])
        ->name('users.show_ru')
        ->middleware(
            [
                'age',
                'checkCountry:renext@mail.ru'
            ])
    ;

    Route::get('{locale}/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])
        ->name('users.show_locale')
        ->middleware(
            [
                //'age',
                //'checkCountry:renext@mail.ru'
            ])
    ;

    Route::get('{locale}/users', [\App\Http\Controllers\UserController::class, 'index'])
        ->name('users.show_ru_locale')
        ->middleware(
            [
                'checkLocale',
                'age',
                'checkCountry:renext@mail.ru'
            ])
    ;

    Route::get('/users_cache', function (Request $request) {


        //dump(User::remember(1000)->where('id', '<', '50')->get());

        /*dump(Cache::get('users'));

        Cache::put('users', \App\Models\User::find(1), 200);*/
        //Cache::put('users2', 11112);
        //Cache::store('redis')->put('users', 1111);
        $b = Cache::remember(User::getCacheKey($request->input('user_id',1)), 600, function() use ($request){
                dump('cache missing');
                return User::find($request->input('user_id',1));
            });
        dump($b);
        /*$b = Cache::tags('users')
            ->remember(User::getCacheKey($request->input('user_id',1)), 600, function() use ($request){
            return User::find($request->input('user_id',1));
        });
        dump($b);*/
        return 'users cahce';
    });

    Route::get('/users_get', function (Request $request) {

        $b = Cache::tags('users')->get('users_3');

        dump($b);
        return 'users get cahce 3';
    });

    Route::get('/users_flush', function (Request $request) {

        $b = Cache::tags('users')->flush();

        dump($b);
        return 'users cache flush 3';
    });

    Route::get('/users_change', function (Request $request) {

        $user = User::find(1);
        $user->name = 'name4';
        $user->save();

        return 'users change ok';
    });
});

Route::get('/calc-tr', function (TransactionsCalcService $transactionsCalcService) {

    //$transactions = UserTransaction::all();
    $transactionsIds = UserTransaction::all()->map->id->toArray();

    $job = new CalcTransactions($transactionsIds);

    dispatch($job);

    //$res = $transactionsCalcService->calc($transactions);

    return 'scheluled';
});

Route::get('/mem', function () {
    // ...
    //phpinfo();

    /*try

    {
        $memcached = new Memcached();
        $memcached->addServer("192.168.160.9", 11211);
        $response = $memcached->get("sample_key2");

        if($response==true)
        {
            echo $response;
        }

        else

        {
            echo "Cache is empty";
            $memcached->set("sample_key2", "Sample data from cache") ;
        }
    }
    catch (exception $e)
    {
        echo $e->getMessage();
    }*/

    if (class_exists('Memcache')) {
        //$server = '172.25.0.9';
        $server = '192.168.160.9';
        $server = '192.168.208.9';
        if (!empty($_REQUEST['server'])) {
            $server = $_REQUEST['server'];
        }
        $memcache = new Memcache;
        $isMemcacheAvailable = $memcache->connect($server);

        if ($isMemcacheAvailable) {
            $aData = $memcache->get('data');
            echo '<pre>';
            if ($aData) {
                echo '<h2>Data from Cache:</h2>';
                print_r($aData);
            } else {
                $aData = array(
                    'me' => 'you',
                    'us' => 'them',
                );
                echo '<h2>Fresh Data:</h2>';
                print_r($aData);
                $memcache->set('data', $aData, 0, 300);
            }
            $aData = $memcache->get('data');
            if ($aData) {
                echo '<h3>Memcache seem to be working fine!</h3>';
            } else {
                echo '<h3>Memcache DOES NOT seem to be working!</h3>';
            }
            echo '</pre>';
        }
    }
    if (!$isMemcacheAvailable) {
        echo 'Memcache not available';
    }


    $xxx = Cache::getStore();
    dump($xxx);
    //$store = 'redis';
    $store = 'memcached';
    Cache::put('test1', 2);
    $b = Cache::store($store)->remember('test1', 600, function() use ($store) {
        dump('cache missing');
        return Cache::store($store)->get('test1', 555);
    });
    dump($b);

    //$stats = Cache::getMemcached()->getStats();

    //dd($stats);
    return 'ok';

    return view('tasks', [
        'tasks' => $tasks,
        'stats' => array_pop($stats)
    ]);
});
