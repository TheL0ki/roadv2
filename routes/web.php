<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use Illuminate\Contracts\Database\Eloquent\Builder;

Route::get('/', [ScheduleController::class, 'index']);
Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'show']);

Route::get('/settings', function () {
    return view('settings');
});

Route::get('/batch', function () {
    return view('batch');
});

Route::get('/userManagement', function () {
    return view('user.show');
});

Route::get('/shiftManagement', function () {
    return view('shift.show');
});
