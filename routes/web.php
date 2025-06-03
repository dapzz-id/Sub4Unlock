<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UnlockController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/auth/register', [AuthController::class, 'register']);
});

// Unlock Routes
Route::get('/unlock/{shortCode}', [UnlockController::class, 'show'])->name('unlock.show');
Route::post('/unlock/{shortCode}/complete', [UnlockController::class, 'complete'])->name('unlock.complete');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/links', [AdminController::class, 'store'])->name('admin.links.store');
    Route::put('/links/{link}', [AdminController::class, 'update'])->name('admin.links.update');
    Route::delete('/links/{link}', [AdminController::class, 'destroy'])->name('admin.links.destroy');
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
});