<?php

use App\Http\Middleware\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingsController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [ScheduleController::class, 'index']);
    Route::get('/schedule/change/{id}/{year}/{month}', [ScheduleController::class, 'edit'])->middleware(Role::class);
    Route::patch('/schedule/{id}/update', [ScheduleController::class, 'update'])->middleware(Role::class);
    Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'show']);

    Route::get('/settings', [SettingsController::class, 'index']);
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::patch('/settings/pwdUpdate', [SettingsController::class, 'updatePassword'])->name('password.update');

    Route::get('/logout', [SessionController::class, 'destroy']);
});


Route::middleware(Role::class)->group(function () {
    Route::get('/batch', [BatchController::class, 'index']);

    Route::get('/userManagement', [UserController::class, 'index']);
    Route::post('/userManagement/store', [UserController::class, 'store'])->name('user.store');
    Route::patch('/userManagement/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/userManagement/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/teamManagement', [TeamController::class, 'index']);
    Route::post('/teamManagement/store', [TeamController::class, 'store'])->name('team.store');
    Route::patch('/teamManagement/{id}/update', [TeamController::class, 'update'])->name('team.update');
    Route::delete('/teamManagement/{id}/destroy', [TeamController::class, 'destroy'])->name('team.destroy');

    Route::get('/shiftManagement', [ShiftController::class, 'index']);
    Route::post('/shiftManagement/store', [ShiftController::class, 'store'])->name('shift.store');
    Route::patch('/shiftManagement/{id}/update', [ShiftController::class, 'update'])->name('shift.update');
    Route::delete('/shiftManagement/{id}/destroy', [ShiftController::class, 'destroy'])->name('shift.destroy'); 
});