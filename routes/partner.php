<?php

use App\Http\Controllers\Mitra\MitraController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:partner'])->group(function () {
    Route::get('/dashboard', [MitraController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [MitraController::class, 'products'])->name('products');
    Route::get('/products/create', [MitraController::class, 'createProduct'])->name('products.create');
    Route::post('/products/store', [MitraController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [MitraController::class, 'editProduct'])->name('products.edit');
    Route::post('/products/{id}/update', [MitraController::class, 'updateProduct'])->name('products.update');
    Route::post('/products/{id}/toggle', [MitraController::class, 'toggleProductStatus'])->name('products.toggle');
    Route::delete('/products/{id}/delete', [MitraController::class, 'deleteProduct'])->name('products.delete');

    Route::get('/orders', [MitraController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/confirm', [MitraController::class, 'confirmOrder'])->name('orders.confirm');
    Route::post('/orders/{id}/status', [MitraController::class, 'updateOrderStatus'])->name('orders.update-status');

    Route::get('/complaints', [MitraController::class, 'complaints'])->name('complaints');
    Route::post('/complaints/{id}/respond', [MitraController::class, 'respondToComplaint'])->name('complaints.respond');

    Route::get('/reports', [MitraController::class, 'reports'])->name('reports');
    Route::get('/settings', [MitraController::class, 'settings'])->name('settings');
    Route::get('/logout', [MitraController::class, 'logout'])->name('logout');
});

// Auth routes for partners (no middleware or different middleware)
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login-register', [MitraController::class, 'authPage'])->name('page');
    Route::post('/register', [MitraController::class, 'register'])->name('register');
    Route::post('/login', [MitraController::class, 'login'])->name('login');
    Route::get('/verification', [MitraController::class, 'verificationStatus'])->name('verification');
});

// Backward compatibility alias for mitra.login
Route::get('/auth/login', [MitraController::class, 'authPage'])->name('mitra.login');
Route::get('/auth/register', [MitraController::class, 'authPage'])->name('mitra.register');
