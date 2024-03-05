<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::put('update-device', [
    App\Http\Controllers\UserController::class,
    'updateDeviceId'
])->middleware(["auth:sanctum"]);