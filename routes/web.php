<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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

// Authentication Pages (Fortify backend, Inertia frontend)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return Inertia::render('Auth/Login');
    })->name('login');

    Route::get('/register', function () {
        return Inertia::render('Auth/Register');
    })->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});


