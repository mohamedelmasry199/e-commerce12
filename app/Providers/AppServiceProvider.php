<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    Paginator::useBootstrapFour();
    //     Gate::define('update-post', function (User $user, Post $post) {
    //     return $user->id === $post->user_id;
    // });
    foreach(config('permessions_en') as $config_permession =>$value){
        Gate::define($config_permession,function($auth) use($config_permession){
            return $auth->hasAccess($config_permession);
    });
    }
    }
}

