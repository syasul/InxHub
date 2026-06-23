<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinktreeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Public routes
Route::get('/', [LinktreeController::class, 'show'])->name('profile');
Route::get('/links/{link}/click', [LinktreeController::class, 'redirect'])->name('links.click');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin panel routes (protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/links', [AdminController::class, 'storeLink'])->name('admin.links.store');
    Route::put('/links/{link}', [AdminController::class, 'updateLink'])->name('admin.links.update');
    Route::delete('/links/{link}', [AdminController::class, 'destroyLink'])->name('admin.links.destroy');
    Route::post('/links/reorder', [AdminController::class, 'reorderLinks'])->name('admin.links.reorder');
});
