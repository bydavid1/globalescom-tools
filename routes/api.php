<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Tools\Bizig\AnswerController;
use App\Http\Controllers\Tools\Bizig\PerspectiveController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\Tools\Bizig\DashboardController;
use App\Models\Company;
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

Route::get('/perspectives', [PerspectiveController::class, 'getPerspectives']);

Route::get('/perspectives/{id}', [PerspectiveController::class, 'getPerspective']);

Route::post('/answers/batch', [AnswerController::class, 'saveBatch']);

Route::put('/answers/batch', [AnswerController::class, 'updateBatch']);

Route::post('/reminder', [ReminderController::class, 'sendReminder']);

Route::controller(CompanyController::class)->prefix('/companies')->group(function () {
    Route::get('/', 'getCompanies');
    Route::get('/{id}', 'getCompany');
    Route::post('/', 'createCompany');
    Route::put('/{id}', 'updateCompany');
});

// Rutas de login y registro
Route::prefix('auth')->group(function () {
    require __DIR__ . '/Auth/auth.php';
});

Route::prefix('user')->group(function () {
    require __DIR__ . '/User/user.php';
})->middleware(["auth:sanctum"]); // Protege las rutas con autenticación


Route::get('/dashboard', [DashboardController::class, 'getProgress']);

Route::get('/tools', [ToolController::class, 'getTools']);
