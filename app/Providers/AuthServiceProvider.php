<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Policies\PostPolicy;
use App\Policies\TagPolicy;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    public const ADMINS = 'admins-only';
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         //'App\Models\Model' => 'App\Policies\ModelPolicy',
        // 'App\Models\Post' => 'App\Policies\PostPolicy',
        Post::class => PostPolicy::class,
        Tag::class => TagPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Auth::viaRemember()
        Auth::viaRequest('api_token', function (Request $request){

            return User::where('api_token', $request->token)->first();
        });

        $this->gates();
    }

    protected function gates()
    {
        Gate::define(self::ADMINS, function (User $user) {

            return \Auth::user()->isAdmin();
            return $user->email === 'renext@mail.ru';
        });

        Gate::define('admin.posts.create', function (User $user) {
            dd('2222222111');
            return $user->email === 'renext@mail.ru';
        });

        Gate::define('update', function (User $user) {
            return \Auth::user()->isAdmin();
            //return $user->email === 'renext@mail.ru';
        });
    }
}
