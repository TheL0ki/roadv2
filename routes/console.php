<?php

use App\Console\Commands\NotifySlackShiftUser;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(NotifySlackShiftUser::class)
    ->weekdays()
    ->dailyAt('13:00')
    ->timezone('Europe/Berlin');
