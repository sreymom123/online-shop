<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

// ===== Login Route (required by Sanctum) =====
Route::get('/login', function () {
    return response()->json(['message' => 'Please login via API'], 401);
})->name('login');

// ===== Admin Auth Routes (no middleware - public) =====
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
});

// ===== Admin Protected Routes (requires admin login) =====
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products',   ProductController::class);
    Route::resource('orders',     OrderController::class);
    Route::resource('users',      UserController::class);
});

// Redirect / to admin dashboard
Route::get('/', function () {
    return redirect('/admin/dashboard');
});