<?php

namespace App\Providers;

use App\Services\Notification\EmailNotificationService;
use App\Services\Notification\LogNotificationService;
use App\Services\Notification\NotificationService;
use App\Services\PostService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('myint', function(){
            return '122';
        });

        //$this->app->bind(NotificationService::class, LogNotificationService::class);
        //$emailNotificationService = app(EmailNotificationService::class);

        //$this->app->instance(NotificationService::class, $emailNotificationService);

        $this->app->bind(NotificationService::class, EmailNotificationService::class);

        $this->app->when(PostService::class)
            ->needs(NotificationService::class)
            ->give(LogNotificationService::class);

        $this->app->when(LogNotificationService::class)
            ->needs('$count')
            ->give(2);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
