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
use App\Http\Controllers\apiAccessController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
    Route::get('/test', [SessionController::class, 'test'])->name('test');
    Route::get('/mailable', function () {
        $user = App\Models\User::find(1);

        return new App\Mail\ScheduleChanged($user, new DateTime());
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/', [ScheduleController::class, 'index'])->name('index');
    Route::get('/schedule/change/{id}/{year}/{month}', [ScheduleController::class, 'edit'])->middleware(Role::class);
    Route::patch('/schedule/{id}/update', [ScheduleController::class, 'update'])->middleware(Role::class);
    Route::get('/schedule/{year}/{month}/{team}', [ScheduleController::class, 'show']);
    Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'show'])->name('schedule');

    Route::get('/settings', [SettingsController::class, 'index']);
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::patch('/settings/pwdUpdate', [SettingsController::class, 'updatePassword'])->name('password.update');

    Route::get('/logout', [SessionController::class, 'destroy']);
});


Route::middleware(Role::class)->group(function () {
    Route::get('/batch', [BatchController::class, 'index']);
    Route::post('/batch/update', [BatchController::class, 'store']);
    Route::post('/batch/holiday', [BatchController::class,'storeHoliday'])->name('batch.holiday');

    Route::get('/userManagement', [UserController::class, 'index']);
    Route::post('/userManagement', [UserController::class, 'store'])->name('employee.save');
    Route::patch('/userManagement/{id}', [UserController::class, 'update'])->name('employee.update');
    Route::delete('/userManagement/{id}', [UserController::class, 'destroy'])->name('employee.destroy');

    Route::get('/teamManagement', [TeamController::class, 'index']);
    Route::post('/teamManagement', [TeamController::class, 'store'])->name('teams.store');
    Route::patch('/teamManagement/{id}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teamManagement/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');

    Route::get('/shiftManagement', [ShiftController::class, 'index']);
    Route::post('/shiftManagement', [ShiftController::class, 'store'])->name('shifts.store');
    Route::patch('/shiftManagement/{id}', [ShiftController::class, 'update'])->name('shifts.update');
    Route::delete('/shiftManagement/{id}', [ShiftController::class, 'destroy'])->name('shifts.destroy');
    
    Route::get('/apiAccess', [apiAccessController::class, 'index']);
    Route::post('/apiAccess', [apiAccessController::class, 'store']);
    Route::delete('/apiAccess', [apiAccessController::class, 'destroy']);
});