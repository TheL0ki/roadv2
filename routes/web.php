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
    Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'show']);

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