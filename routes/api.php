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

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    Route::prefix('library')->group(function () {
        Route::get('/', [LibraryController::class, 'index']);
        Route::post('/{game}', [LibraryController::class, 'store']);
        Route::delete('/{game}', [LibraryController::class, 'destroy']);
    });

    Route::prefix('game')->group(function () {
        Route::get('/', [GameController::class, 'index']);
        Route::get('/random', [GameController::class, 'random']);
        Route::get('/{id}', [GameController::class, 'show']);
    });

    Route::prefix('guest')->group(function () {
        Route::get('/', [GuestController::class, 'index']);
        Route::post('/', [GuestController::class, 'store']);
    });

    Route::prefix('score')->group(function () {
        Route::get('/{game?}', [ScoreController::class, 'index']);
        Route::get('/detail/{id}', [ScoreController::class, 'show']);
        Route::post('/', [ScoreController::class, 'store']);
    });

    Route::get('/template/{game}', [TemplateController::class, 'index']);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::get('/mechanic', [MechanicController::class, 'index']);
});
