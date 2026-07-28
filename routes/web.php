<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'farmer' => redirect()->route('farmer.dashboard'),
        'buyer' => redirect()->route('buyer.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
    };
})->middleware(['auth'])->name('dashboard');

Route::get('/farmer/dashboard', function () {
    return view('farmer.dashboard');
})->middleware(['auth', 'role:farmer'])->name('farmer.dashboard');

Route::get('/farmer/products', [\App\Http\Controllers\Farmer\ProductController::class, 'index'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.products.index');

Route::get('/farmer/products/create', [\App\Http\Controllers\Farmer\ProductController::class, 'create'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.products.create');

Route::post('/farmer/products', [\App\Http\Controllers\Farmer\ProductController::class, 'store'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.products.store');

Route::get('/farmer/products/{product}', [\App\Http\Controllers\Farmer\ProductController::class, 'show'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.products.show');

Route::get('/farmer/orders', [\App\Http\Controllers\Farmer\OrderController::class, 'index'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.orders.index');

Route::get('/farmer/orders/{order}', [\App\Http\Controllers\Farmer\OrderController::class, 'show'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.orders.show');

Route::patch('/farmer/orders/{order}/status', [\App\Http\Controllers\Farmer\OrderController::class, 'updateStatus'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.orders.updateStatus');

Route::get('/buyer/dashboard', function () {
    return view('buyer.dashboard');
})->middleware(['auth', 'role:buyer'])->name('buyer.dashboard');

Route::get('/marketplace', [\App\Http\Controllers\Buyer\MarketplaceController::class, 'index'])
    ->middleware(['auth', 'role:buyer'])
    ->name('marketplace.index');

Route::get('/marketplace/{product}', [\App\Http\Controllers\Buyer\MarketplaceController::class, 'show'])
    ->middleware(['auth', 'role:buyer'])
    ->name('marketplace.show');

Route::get('/cart', [\App\Http\Controllers\Buyer\CartController::class, 'index'])
    ->middleware(['auth', 'role:buyer'])
    ->name('cart.index');

Route::post('/cart/{product}', [\App\Http\Controllers\Buyer\CartController::class, 'store'])
    ->middleware(['auth', 'role:buyer'])
    ->name('cart.store');

Route::patch('/cart/item/{cartItem}', [\App\Http\Controllers\Buyer\CartController::class, 'update'])
    ->middleware(['auth', 'role:buyer'])
    ->name('cart.update');

Route::delete('/cart/item/{cartItem}', [\App\Http\Controllers\Buyer\CartController::class, 'destroy'])
    ->middleware(['auth', 'role:buyer'])
    ->name('cart.destroy');

Route::get('/checkout', [\App\Http\Controllers\Buyer\OrderController::class, 'checkout'])
    ->middleware(['auth', 'role:buyer'])
    ->name('checkout');

Route::post('/checkout', [\App\Http\Controllers\Buyer\OrderController::class, 'store'])
    ->middleware(['auth', 'role:buyer'])
    ->name('orders.store');

Route::get('/orders', [\App\Http\Controllers\Buyer\OrderController::class, 'index'])
    ->middleware(['auth', 'role:buyer'])
    ->name('orders.index');

Route::get('/orders/{order}', [\App\Http\Controllers\Buyer\OrderController::class, 'show'])
    ->middleware(['auth', 'role:buyer'])
    ->name('orders.show');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::middleware(['auth', 'role:farmer,buyer'])->group(function () {
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';