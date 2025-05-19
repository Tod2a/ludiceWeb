<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\LibraryController;
use App\Http\Controllers\Api\MechanicController;
use App\Http\Controllers\Api\ScoreController;
use App\Http\Controllers\Api\TemplateController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('library')->group(function () {
    Route::get('/', [LibraryController::class, 'index']);
    Route::post('/{game}', [LibraryController::class, 'store']);
    Route::delete('/{game}', [LibraryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('game')->group(function () {
    Route::get('/', [GameController::class, 'index']);
    Route::get('/random', [GameController::class, 'random']);
    Route::get('/{id}', [GameController::class, 'show']);
});

Route::middleware('auth:sanctum')->prefix('guest')->group(function () {
    Route::get('/', [GuestController::class, 'index']);
    Route::post('/', [GuestController::class, 'store']);
});

Route::middleware('auth:sanctum')->prefix('score')->group(function () {
    Route::get('/{game?}', [ScoreController::class, 'index']);
    Route::post('/', [ScoreController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/template/{game}', [TemplateController::class, 'index']);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/mechanic', [MechanicController::class, 'index']);
});
