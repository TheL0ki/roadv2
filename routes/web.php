<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingsController;

Route::get('/', [ScheduleController::class, 'index']);
Route::get('/schedule/change/{id}', [ScheduleController::class, 'edit']);
Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'show']);

Route::get('/settings', [SettingsController::class, 'index']);

Route::get('/batch',[BatchController::class, 'index']);

Route::get('/userManagement', [UserController::class, 'index']);

Route::get('/shiftManagement', [ShiftController::class, 'index']);
