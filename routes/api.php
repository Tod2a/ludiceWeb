<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\GameController;
use App\Http\Controllers\api\GuestController;
use App\Http\Controllers\api\LibraryController;
use App\Http\Controllers\api\ScoreController;
use App\Http\Controllers\api\TemplateController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('library')->group(function () {
    Route::get('/', [LibraryController::class, 'index']);
    Route::post('/', [LibraryController::class, 'store']);
    Route::delete('/', [LibraryController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('game')->group(function () {
    Route::get('/', [GameController::class, 'index']);
    Route::get('/random', [GameController::class, 'random']);
    Route::get('/filters', [GameController::class, 'filters']);
});

Route::middleware('auth:sanctum')->prefix('guest')->group(function () {
    Route::get('/', [GuestController::class, 'index']);
    Route::post('/', [GuestController::class, 'store']);
});

Route::middleware('auth:sanctum')->prefix('score')->group(function () {
    Route::get('/', [ScoreController::class, 'index']);
    Route::post('/', [ScoreController::class, 'strore']);
});

Route::middleware('auth:sanctum')->prefix('template')->group(function () {
    Route::get('/', [TemplateController::class, 'index']);
});
