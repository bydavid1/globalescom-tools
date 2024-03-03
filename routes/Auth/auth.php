<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [
    App\Http\Controllers\AuthController::class,
    'register'
]);

Route::post('login', [
    App\Http\Controllers\AuthController::class,
    'login'
]);

Route::post('logout', [
    App\Http\Controllers\AuthController::class,
    'logout'
]);

// rutas roles
Route::post('user-role', [
    App\Http\Controllers\AuthController::class,
    'getRoles'
]);