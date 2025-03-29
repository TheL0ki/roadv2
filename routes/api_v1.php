<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ShiftController;

Route::middleware('auth:sanctum')->apiResource('/user', UserController::class);
Route::middleware('auth:sanctum')->apiResource('/shift', ShiftController::class);
Route::middleware('auth:sanctum')->apiResource('/team', TeamController::class);
