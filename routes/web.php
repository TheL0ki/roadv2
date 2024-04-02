<?php

use App\Models\Schedule;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $schedule = Schedule::with('shift')->paginate(3);

    return view('home', [
        'schedule' => $schedule
    ]);
});

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/batch', function () {
    return view('batch');
});

Route::get('/userManagement', function () {
    return view('userManagement');
});

Route::get('/shiftManagement', function () {
    return view('shiftManagement');
});
