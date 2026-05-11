<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomController::class, "index"])->name('rooms.index');
        Route::get('/create', [RoomController::class, "create"])->name('rooms.create');
        Route::post('/store', [RoomController::class, "store"])->name('rooms.store');
        Route::get('/{room}/edit', [RoomController::class, "edit"])->name('rooms.edit');
        Route::put('/{room}/update', [RoomController::class, "update"])->name('rooms.update');
        Route::delete('/{room}/delete', [RoomController::class, "destroy"])->name('rooms.destroy');
    });

    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/store', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/{booking}/show', [BookingController::class, 'show'])->name('bookings.show');
        Route::patch('/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/{user}/update', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.view');
        Route::put('/update-info', [ProfileController::class, 'update'])->name('profile.info.update');
        Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

    Route::prefix('audit')->group(function () {
        Route::get('/', [AuditController::class, 'index'])->name('audit.index');
    });
});
