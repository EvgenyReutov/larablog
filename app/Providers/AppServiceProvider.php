<?php

namespace App\Providers;

use App\Repo\Post\PostEloquentRepo;
use App\Repo\Post\PostRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PostRepo::class, PostEloquentRepo::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
