<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Tools\Bizig\AnswerController;
use App\Http\Controllers\Tools\Bizig\PerspectiveController;
use App\Http\Controllers\ReminderController;
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

Route::group('/companies', function () {
    Route::get('/', [CompanyController::class, 'getCompanies']);
    Route::get('/{id}', [CompanyController::class, 'getCompany']);
    Route::post('/', [CompanyController::class, 'createCompany']);
    Route::put('/{id}', [CompanyController::class, 'updateCompany']);
});
