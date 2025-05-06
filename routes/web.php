<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GamesController;
use App\Http\Controllers\Admin\UsersController;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/homepage', [GameController::class, 'index'])->name('connected.homepage');
    Route::get('/game/{gameId}', [GameController::class, 'show'])->name('games.details');
    Route::get('/homepage/search', [GameController::class, 'search'])->name('games.search');
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/{game}', [LibraryController::class, 'store'])->name('library.store');
    Route::delete('/library/{game}', [LibraryController::class, 'destroy'])->name('library.destroy');

    //Admin routes
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users/search', [UsersController::class, 'search'])->name('users.search');
    Route::resource('/admin/users', UsersController::class)->except('create', 'show', 'store', 'edit');

    Route::resource('/admin/games', GamesController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
