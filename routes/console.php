<?php

use App\Jobs\CleanExpiredCheckoutSessionsJob;
use App\Jobs\ReleaseExpiredReservationsJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::job(new ReleaseExpiredReservationsJob)
    ->everyFifteenMinutes();
 Schedule::job(CleanExpiredCheckoutSessionsJob::class)
        ->dailyAt('02:00')
        ->withoutOverlapping();
        

