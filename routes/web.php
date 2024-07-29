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
    Route::get('/schedule/change/{id}/{year}/{month}', [ScheduleController::class, 'edit']);
    Route::patch('/schedule/{id}/update', [ScheduleController::class, 'update']);
    Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'show']);

    Route::get('/settings', [SettingsController::class, 'index']);
    Route::patch('/settings', [SettingsController::class, 'update']);

    Route::delete('/logout', [SessionController::class, 'destroy']); 
});



Route::get('/batch', [BatchController::class, 'index'])->middleware(Role::class);

Route::get('/userManagement', [UserController::class, 'index'])->middleware(Role::class);
Route::post('/userManagement/store', [UserController::class, 'store'])->middleware(Role::class)->name('user.store');
Route::patch('/userManagement/{id}/update', [UserController::class, 'update'])->middleware(Role::class)->name('user.update');
Route::delete('/userManagement/{id}/destroy', [UserController::class, 'destroy'])->middleware(Role::class)->name('user.destroy');

Route::get('/teamManagement', [TeamController::class, 'index'])->middleware(Role::class);

Route::get('/shiftManagement', [ShiftController::class, 'index'])->middleware(Role::class);
Route::post('/shiftManagement/store', [ShiftController::class, 'store'])->middleware(Role::class)->name('shift.store');
Route::patch('/shiftManagement/{id}/update', [ShiftController::class, 'update'])->middleware(Role::class)->name('shift.update');
Route::delete('/shiftManagement/{id}/destroy', [ShiftController::class, 'destroy'])->middleware(Role::class)->name('shift.destroy');
