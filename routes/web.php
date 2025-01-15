<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/homepage', [GameController::class, 'index'])->name('connected.homepage');
    Route::get('/homepage/search', [GameController::class, 'search'])->name('games.search');
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/{game}', [LibraryController::class, 'store'])->name('library.store');
    Route::delete('/library/{game}', [LibraryController::class, 'destroy'])->name('library.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
