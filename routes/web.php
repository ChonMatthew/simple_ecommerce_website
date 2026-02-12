<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Route to Home
Route::get('/', [
    HomeController::class, 'index'])->name('home');

// Public Route to Shop Page
Route::get('/products', function () {
    $products = Product::query()
        ->latest()
        ->get();

    return inertia('Shop', [
        'products' => $products,
    ]);
});

// Route to Cart
Route::get('/cart', [
    CartController::class, 'index'])->name('cart.index');

Route::post('/cart', [
    CartController::class, 'store'])->name('cart.store');

Route::patch('/cart/{cart_item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cart_item}', [CartController::class, 'destroy'])->name('cart.destroy');

// Public Routes (no login required)
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes (no login required)
// Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::post('/cart', [CartController::class, 'store'])->name('cart.store');

// Order Routes (no login required)
// Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
// Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
// Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');

// TODO: Add login required routes

// // Cart Routes (login required)
// Route::middleware('auth')->group(function () {
//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
//     Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
//     Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
// });

// // Order Routes (login required)
// Route::middleware('auth')->group(function () {
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
//     Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
//     Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
// });

// Authentication Pages (Fortify backend, Inertia frontend)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    Route::get('/register', function () {
        return Inertia::render('Auth/Register');
    })->name('register');
});
