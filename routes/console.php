<?php

use App\Console\Commands\NotifySlackShiftUser;
use App\Console\Commands\SendShiftReport;
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

Schedule::command(SendShiftReport::class)
    ->monthlyOn(1, '08:00')
    ->timezone('Europe/Berlin');
