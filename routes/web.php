<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'farmer' => redirect()->route('farmer.products.index'),
        'buyer' => redirect()->route('marketplace.index'),
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

Route::get('/farmer/bids', [\App\Http\Controllers\Farmer\BidController::class, 'index'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.bids.index');

Route::patch('/farmer/bids/{bid}/accept', [\App\Http\Controllers\Farmer\BidController::class, 'accept'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.bids.accept');

Route::patch('/farmer/bids/{bid}/reject', [\App\Http\Controllers\Farmer\BidController::class, 'reject'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.bids.reject');

Route::get('/farmer/analytics', [\App\Http\Controllers\Farmer\AnalyticsController::class, 'index'])
    ->middleware(['auth', 'role:farmer'])
    ->name('farmer.analytics.index');

Route::get('/buyer/dashboard', function () {
    return view('buyer.dashboard');
})->middleware(['auth', 'role:buyer'])->name('buyer.dashboard');

Route::get('/buyer/analytics', [\App\Http\Controllers\Buyer\AnalyticsController::class, 'index'])
    ->middleware(['auth', 'role:buyer'])
    ->name('buyer.analytics.index');

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

Route::post('/buy-now/{product}', [\App\Http\Controllers\Buyer\CartController::class, 'buyNow'])
    ->middleware(['auth', 'role:buyer'])
    ->name('cart.buyNow');

Route::patch('/cart/item/{cartItem}', [\App\Http\Controllers\Buyer\CartController::class, 'update'])
    ->middleware(['auth', 'role:buyer'])
    ->name('cart.update');

Route::delete('/cart/item/{cartItem}', [\App\Http\Controllers\Buyer\CartController::class, 'destroy'])
    ->middleware(['auth', 'role:buyer'])
    ->name('cart.destroy');

Route::post('/products/{product}/bids', [\App\Http\Controllers\Buyer\BidController::class, 'store'])
    ->middleware(['auth', 'role:buyer'])
    ->name('bids.store');

Route::get('/my-offers', [\App\Http\Controllers\Buyer\BidController::class, 'index'])
    ->middleware(['auth', 'role:buyer'])
    ->name('bids.index');

Route::patch('/my-offers/{bid}/cancel', [\App\Http\Controllers\Buyer\BidController::class, 'cancel'])
    ->middleware(['auth', 'role:buyer'])
    ->name('bids.cancel');

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

Route::post('/orders/{order}/review', [\App\Http\Controllers\Buyer\ReviewController::class, 'store'])
    ->middleware(['auth', 'role:buyer'])
    ->name('orders.review');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::get('/admin/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.users.index');

Route::get('/admin/users/{user}', [\App\Http\Controllers\Admin\UserManagementController::class, 'show'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.users.show');

Route::patch('/admin/users/{user}/toggle-active', [\App\Http\Controllers\Admin\UserManagementController::class, 'toggleActive'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.users.toggleActive');

Route::get('/admin/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.reports.index');

Route::patch('/admin/reports/{report}/status', [\App\Http\Controllers\Admin\ReportController::class, 'updateStatus'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.reports.updateStatus');

Route::get('/admin/advisories/create', [\App\Http\Controllers\Admin\AdvisoryController::class, 'create'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.advisories.create');

Route::post('/admin/advisories', [\App\Http\Controllers\Admin\AdvisoryController::class, 'store'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.advisories.store');

Route::delete('/admin/advisories/{advisory}', [\App\Http\Controllers\Admin\AdvisoryController::class, 'destroy'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.advisories.destroy');

Route::get('/market-analytics', [\App\Http\Controllers\MarketAnalyticsController::class, 'index'])
    ->middleware(['auth'])
    ->name('market-analytics.index');

Route::middleware(['auth', 'role:farmer,buyer'])->group(function () {
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
});

Route::middleware(['auth', 'role:farmer,buyer'])->group(function () {
    Route::get('/reports/{user}/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/{user}', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{notification}/redirect', [\App\Http\Controllers\NotificationController::class, 'redirect'])->name('notifications.redirect');
});

Route::get('/auth/google/redirect', [\App\Http\Controllers\Auth\GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\GoogleController::class, 'callback'])->name('google.callback');
Route::get('/auth/google/register', [\App\Http\Controllers\Auth\GoogleController::class, 'showRegisterForm'])->name('google.register');
Route::post('/auth/google/register', [\App\Http\Controllers\Auth\GoogleController::class, 'completeRegistration'])->name('google.register.store');

require __DIR__.'/auth.php';