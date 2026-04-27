<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\ProfileController;
use App\Models\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // All authenticated users can view players, events, coaches, and management
    Route::get('players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('events', [EventController::class, 'index'])->name('events.index');
    Route::get('coaches', [CoachController::class, 'index'])->name('coaches.index');
    Route::get('management', [ManagementController::class, 'index'])->name('management.index');

    // Admin-only: manage players, events, and users
    Route::middleware('admin')->group(function () {
        Route::get('players/create', [PlayerController::class, 'create'])->name('players.create');
        Route::post('players', [PlayerController::class, 'store'])->name('players.store');
        Route::get('players/{profile}/edit', [PlayerController::class, 'edit'])->name('players.edit');
        Route::match(['PUT', 'PATCH'], 'players/{profile}', [PlayerController::class, 'update'])->name('players.update');
        Route::delete('players/{profile}', [PlayerController::class, 'destroy'])->name('players.destroy');

        Route::get('coaches/create', [CoachController::class, 'create'])->name('coaches.create');
        Route::post('coaches', [CoachController::class, 'store'])->name('coaches.store');
        Route::get('coaches/{profile}/edit', [CoachController::class, 'edit'])->name('coaches.edit');
        Route::match(['PUT', 'PATCH'], 'coaches/{profile}', [CoachController::class, 'update'])->name('coaches.update');
        Route::delete('coaches/{profile}', [CoachController::class, 'destroy'])->name('coaches.destroy');

        Route::get('management/create', [ManagementController::class, 'create'])->name('management.create');
        Route::post('management', [ManagementController::class, 'store'])->name('management.store');
        Route::get('management/{profile}/edit', [ManagementController::class, 'edit'])->name('management.edit');
        Route::match(['PUT', 'PATCH'], 'management/{profile}', [ManagementController::class, 'update'])->name('management.update');
        Route::delete('management/{profile}', [ManagementController::class, 'destroy'])->name('management.destroy');

        Route::get('events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('events', [EventController::class, 'store'])->name('events.store');
        Route::get('events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::match(['PUT', 'PATCH'], 'events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');
            Route::resource('users', AdminUserController::class)->except(['show']);
        });
    });

    Route::get('players/{profile}', [PlayerController::class, 'show'])->name('players.show');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('coaches/{profile}', [CoachController::class, 'show'])->name('coaches.show');
    Route::get('management/{profile}', [ManagementController::class, 'show'])->name('management.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
