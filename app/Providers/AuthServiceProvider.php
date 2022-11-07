<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(self::ADMINS, function (User $user) {
            return $user->email === 'renext@mail.ru';
        });


        Gate::define('admin.posts.create', function (User $user) {
            return $user->email === 'renext@mail.ru';
        });

        Gate::define('update', function (User $user) {

            return true;
            return $user->email === 'renext@mail.ru';
        });

    }
}
