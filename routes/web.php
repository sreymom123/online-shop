<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

// ===== Login Route (required by Sanctum) =====
Route::get('/login', function () {
    return response()->json(['message' => 'Please login via API'], 401);
})->name('login');

// ===== Admin Routes =====
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
});

// Redirect / to admin
Route::get('/', function () {
    return redirect('/admin/categories');
});