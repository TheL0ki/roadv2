<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $user = User::with('schedule.shift')->get();

    return view('home', [
        'user' => $user
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
