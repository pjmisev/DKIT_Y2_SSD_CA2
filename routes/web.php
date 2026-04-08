<?php

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // All authenticated users can view players and events
    Route::get('players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('events', [EventController::class, 'index'])->name('events.index');

    // Admin-only: manage players, events, and users
    Route::middleware('admin')->group(function () {
        Route::get('players/create', [PlayerController::class, 'create'])->name('players.create');
        Route::post('players', [PlayerController::class, 'store'])->name('players.store');
        Route::get('players/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
        Route::match(['PUT', 'PATCH'], 'players/{player}', [PlayerController::class, 'update'])->name('players.update');
        Route::delete('players/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');

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

    Route::get('players/{player}', [PlayerController::class, 'show'])->name('players.show');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
