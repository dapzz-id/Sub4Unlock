<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdNetworkController;
use App\Http\Controllers\UnlockController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;

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

Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
    
    // Ad Networks Routes
    Route::get('/ad-networks', [AdNetworkController::class, 'index'])->name('superadmin.ad-networks');
    Route::post('/ad-networks', [AdNetworkController::class, 'store'])->name('superadmin.ad-networks.store');
    Route::put('/ad-networks/{adNetwork}', [AdNetworkController::class, 'update'])->name('superadmin.ad-networks.update');
    Route::delete('/ad-networks/{adNetwork}', [AdNetworkController::class, 'destroy'])->name('superadmin.ad-networks.destroy');
    Route::post('/ad-networks/{adNetwork}/test', [AdNetworkController::class, 'testConnection'])->name('superadmin.ad-networks.test');
    Route::post('/ad-networks/{adNetwork}/toggle', [AdNetworkController::class, 'toggleStatus'])->name('superadmin.ad-networks.toggle');
    
    // User Management
    Route::get('/users', [SuperAdminController::class, 'users'])->name('superadmin.users');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('superadmin.users.store');
    Route::put('/users/{user}', [SuperAdminController::class, 'updateUser'])->name('superadmin.users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('superadmin.users.destroy');
});