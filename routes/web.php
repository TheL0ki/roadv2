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

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::delete('/logout', [SessionController::class, 'destroy']);

Route::get('/', [ScheduleController::class, 'index']);
Route::get('/schedule/change/{id}/{year}/{month}', [ScheduleController::class, 'edit']);
Route::patch('/schedule/{id}/update', [ScheduleController::class, 'update']);
Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'show']);

Route::get('/settings', [SettingsController::class, 'index']);

Route::get('/batch', [BatchController::class, 'index'])->middleware(Role::class);

Route::get('/userManagement', [UserController::class, 'index'])->middleware(Role::class);

Route::get('/teamManagement', [TeamController::class, 'index'])->middleware(Role::class);

Route::get('/shiftManagement', [ShiftController::class, 'index'])->middleware(Role::class);
