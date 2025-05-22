<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CreatorController as AdminCreatorController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GamesController;
use App\Http\Controllers\Admin\MechanicController as AdminMechanicController;
use App\Http\Controllers\Admin\PublisherController as AdminPublisherController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\PublisherController;
use GuzzleHttp\Middleware;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomepageController::class, 'index'])->name('homepage');
Route::get('/privacy-policy', [PrivacyController::class, 'index'])->name('privacy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/homepage', [GameController::class, 'index'])->name('connected.homepage');
    Route::get('/game/{gameId}', [GameController::class, 'show'])->name('games.details');
    Route::get('/homepage/search', [GameController::class, 'search'])->name('games.search');
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::post('/library/{game}', [LibraryController::class, 'store'])->name('library.store');
    Route::delete('/library/{game}', [LibraryController::class, 'destroy'])->name('library.destroy');

    Route::get('/creators/search', [CreatorController::class, 'search'])->name('creator.search');
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('category.search');
    Route::get('/publishers/search', [PublisherController::class, 'search'])->name('publisher.search');
    Route::get('/mechanics/search', [MechanicController::class, 'search'])->name('mechanic.search');

    //Admin routes
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users/search', [UsersController::class, 'search'])->name('users.search');
    Route::resource('/admin/users', UsersController::class)->except('create', 'show', 'store', 'edit');

    Route::get('/admin/games/search', [GamesController::class, 'search'])->name('admin.games.search');
    Route::resource('/admin/games', GamesController::class)->except('show');

    Route::post('/admin/mechanic', [AdminMechanicController::class, 'store'])->name('mechanic.store');
    Route::post('/admin/category', [AdminCategoryController::class, 'store'])->name('category.store');
    Route::post('/admin/creator', [AdminCreatorController::class, 'store'])->name('creator.store');
    Route::post('/admin/publisher', [AdminPublisherController::class, 'store'])->name('publisher.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
