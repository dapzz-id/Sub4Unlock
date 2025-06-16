<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdNetworkController;
use App\Http\Controllers\UnlockController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuperAdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/unlock', [UnlockController::class, 'enterCode'])->name('unlock.enter-code');
Route::get('/unlock/{shortCode}', [UnlockController::class, 'show'])->name('unlock.show');
Route::post('/unlock/{shortCode}/complete-step', [UnlockController::class, 'completeStep'])->name('unlock.complete-step');
Route::post('/unlock/{shortCode}/unlock', [UnlockController::class, 'unlock'])->name('unlock.final');

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
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/links', [AdminController::class, 'store'])->name('links.store');
    Route::put('/links/{link}', [AdminController::class, 'update'])->name('links.update');
    Route::delete('/links/{link}', [AdminController::class, 'destroy'])->name('links.destroy');
});

Route::middleware('auth')->prefix('/auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Super Admin Routes
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
    
    // Ad Networks Routes
    Route::get('/ad-networks', [AdNetworkController::class, 'index'])->name('ad-networks');
    Route::post('/ad-networks', [AdNetworkController::class, 'store'])->name('ad-networks.store');
    Route::put('/ad-networks/{adNetwork}', [AdNetworkController::class, 'update'])->name('ad-networks.update');
    Route::delete('/ad-networks/{adNetwork}', [AdNetworkController::class, 'destroy'])->name('ad-networks.destroy');
    Route::post('/ad-networks/{adNetwork}/test', [AdNetworkController::class, 'testConnection'])->name('ad-networks.test');
    Route::post('/ad-networks/{adNetwork}/toggle', [AdNetworkController::class, 'toggleStatus'])->name('ad-networks.toggle');
    
    // User Management
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('storeUser');
    Route::put('/users/{user}', [SuperAdminController::class, 'updateUser'])->name('updateUser');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroyUser'])->name('destroyUser');
});