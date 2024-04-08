<?php

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    
    $date = new DateTime();

    $user = User::with(['schedule' => function ($query) use ($date) {
        $query->with('shift')->where('month', '=', $date->format('n'))->where('year', '=', $date->format('Y'));
    }])->get();

    $table = [];

    foreach ($user as $item) {
        foreach ($item->schedule as $entry) {
            $table[$entry->user_id][$entry->day] = $entry;
        }
    }

    $date = new DateTime();

    return view('table.show', [
        'user' => $user,
        'table' => $table,
        'date' => $date
    ]);
});

Route::get('/schedule/{year}/{month}', function($year, $month) {
    
    $displayDate = $year . '-' . $month . '-01';
    $date = new DateTime($displayDate);

    $user = User::with(['schedule' => function ($query) use ($date) {
        $query->with('shift')->where('month', '=', $date->format('n'))->where('year', '=', $date->format('Y'));
    }])->get();

    $table = [];

    foreach ($user as $item) {
        foreach ($item->schedule as $entry) {
            $table[$entry->user_id][$entry->day] = $entry;
        }
    }

    return view('table.show', [
        'user' => $user,
        'table' => $table,
        'date' => $date
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
