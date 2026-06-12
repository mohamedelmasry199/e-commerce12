<?php

use App\Http\Middleware\MarkNotificationAsRead;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
          $middleware->use([
            MarkNotificationAsRead::class,

        ]);
            $middleware->redirectGuestsTo(function(){
            if(request()->is('*dashboard*')){
                return route('dashboard.login');
            }
            else{
                return route('login');
            }
        });
          $middleware->redirectUsersTo(function(){
            if(request()->is('*dashboard*')){
                return route('dashboard.index');
            }
            else{
                return route('website.home');
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
