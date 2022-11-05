<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
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
            return $user->email === 'renext@mail.ru';
        });

        Gate::define('admin.posts.create', function (User $user) {
            return $user->email === 'renext@mail.ru';
        });
    }
}
