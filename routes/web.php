<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockMovementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::prefix('product')->group(function () {
        Route::get('/index', [ProductController::class, 'list'])->name('product.list');
        Route::get('/create', [ProductController::class, 'create'])->name('product.new');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
    });

    Route::prefix('order')->group(function () {
            
        // Route::get('/', function () { return view('order.list');})->name('order');
        Route::get('/index', [OrderController::class, 'list'])->name('order.list');
        Route::get('/create', [OrderController::class, 'create'])->name('order.new');
        Route::post('/store', [OrderController::class, 'store'])->name('order.store');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('order.show');
        // Route::post('/show/{id}/detail', [OrderController::class, 'showDetail'])->name('order.detail');
        // Route::post('/orders/{id}/review', [OrderController::class, 'approveOrder'])->name('orders.review');
        // Route::post('/orders/{id}/dispatch', [OrderController::class, 'dispatchOrder'])->name('orders.dispatch');
        // Route::post('/orders/fetchByDateRange', [OrderController::class, 'fetchByDateRange'])->name('orders.fetchByDateRange');
    });

    Route::prefix('stock-movement')->group(function () {
        Route::get('/index', [StockMovementController::class, 'list'])->name('stock_movement.list');
        Route::post('/store', [StockMovementController::class, 'store'])->name('stock_movement.store');
    });

    Route::prefix('customer')->group(function () {
        Route::get('/index', [CustomerController::class, 'list'])->name('customer.list');
        Route::get('/create', [CustomerController::class, 'create'])->name('customer.new');
        Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
    });

    // Route::prefix('reports')->group(function () {
    //     Route::get('/orders', [ReportController::class, 'orders'])->name('reports.orders');
    //     Route::post('/sales-by-product', [ReportController::class, 'salesByProduct'])->name('report.salesByProduct');
    // });
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
