<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ShiftController;
use App\Http\Controllers\Api\V1\ScheduleController;

Route::middleware('auth:sanctum')->apiResource('/user', UserController::class);
Route::middleware('auth:sanctum')->apiResource('/shift', ShiftController::class);
Route::middleware('auth:sanctum')->apiResource('/team', TeamController::class);
Route::middleware('auth:sanctum')->apiResource('/schedule', ScheduleController::class);
Route::middleware('auth:sanctum')->get('/schedule/{year}/{month}/{day}', [ScheduleController::class, 'getScheduleByDate']);
