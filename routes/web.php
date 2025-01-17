<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Admin\Auth\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\AdminAuth;

// User Panel
Route::get('/', [GuestController::class, 'dashboard'])->name('dashboard');


// Admin Panel
Route::prefix('admin')->group(function() {

    Route::get('/', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');

    Route::middleware([AdminAuth::class])->group(function() {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::get('/search', [ProductController::class, 'index'])->name('admin.search');

        Route::get('/create', [ProductController::class, 'showCreateForm'])->name('admin.create');
        Route::post('/create', [ProductController::class, 'create'])->name('admin.create.submit');

        Route::get('/view/{id}', [ProductController::class, 'view'])->name('admin.view');

        Route::get('/edit/{id}', [ProductController::class, 'showEditForm'])->name('admin.edit');
        Route::put('/edit/{id}', [ProductController::class, 'update'])->name('admin.update.submit');

        Route::get('/stock/{id}', [ProductController::class, 'showStockForm'])->name('admin.stock');
        Route::post('/stockUpdate/{id}', [ProductController::class, 'stockUpdate'])->name('admin.stockUpdate');

        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.delete');
    });
});
