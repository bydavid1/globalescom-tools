<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Rutas de login y registro
Route::prefix('auth')->group(function () {
    require __DIR__ . '/Auth/auth.php';
});

Route::prefix('user')->group(function () {
    require __DIR__ . '/User/user.php';
})->middleware(["auth:sanctum"]); // Protege las rutas con autenticación

