<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware(["auth:sanctum"]);

Route::get('me', [AuthController::class, 'me'])->middleware(["auth:sanctum"]);
