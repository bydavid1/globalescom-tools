<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::put('update-device-id', [UserController::class, 'updateDeviceId'])->middleware(["auth:sanctum"]);
