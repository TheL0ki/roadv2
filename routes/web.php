<?php

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $user = User::with(['schedule' => function ($query) {
        $query->with('shift')->where('month', "=", 4);
    }])->get();

    return view('table.show', [
        'table' => $user,
        'year' => 2024,
        'month' => 4
    ]);
});

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

Route::Get('/table/{$year}/{$month}', function ($year, $month) {
    return view('table.show', [
        'year' => $year,
        'month' => $month
    ]);
});
