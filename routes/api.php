<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'index']);

Route::prefix('v1')->group(base_path('routes/api_v1.php'));