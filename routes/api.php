<?php

use App\Http\Controllers\API\CodeController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\UserController;
use Brick\Math\Exception\RoundingNecessaryException;
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

//NO AUTH ROUTES
Route::controller(UserController::class)->group(function() {
    Route::post('user', 'create');
    Route::post('user/login', 'login');
});

//AUTH REQUIRED ROUTES
Route::middleware('auth:sanctum')->controller(UserController::class)->group(function() {
    Route::get('user', 'current');
});

Route::middleware('auth:sanctum')->controller(ProjectController::class)->group(function() {
    Route::post('project/', 'create');
    Route::get('project/', 'showAll');
    Route::get('project/{project_id}/generate-code', 'generateCode');
});

Route::middleware('auth:sanctum')->controller(CodeController::class)->group(function() {
    Route::post('code/', 'create');
    Route::get('code/{project_id}', 'showProjectCode');
    Route::put('code/{project_id}', 'update');
});