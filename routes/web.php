<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/payment/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
Route::post('/payment/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout.post');
Route::post('/payment/process', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'km'])) {
        abort(400);
    }
    session(['locale' => $locale]);

    return redirect()->back();
});

// Consumer Authentication Routes (separate from admin)
Route::middleware('guest')->group(function () {
    Route::get('/consumer/register', [\App\Http\Controllers\Consumer\ConsumerAuthController::class, 'register'])->name('consumer.register');
    Route::post('/consumer/register', [\App\Http\Controllers\Consumer\ConsumerAuthController::class, 'store']);

    Route::get('/consumer/login', [\App\Http\Controllers\Consumer\ConsumerAuthController::class, 'login'])->name('consumer.login');
    Route::post('/consumer/login', [\App\Http\Controllers\Consumer\ConsumerAuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/consumer/logout', [\App\Http\Controllers\Consumer\ConsumerAuthController::class, 'logout'])->name('consumer.logout');
    Route::get('/consumer/dashboard', function () {
        $user = auth()->user();
        $orders = \App\Models\Order::where('user_id', $user->id)->latest()->get();
        return view('consumer.dashboard', compact('user', 'orders'));
    })->name('consumer.dashboard');
});

Route::get('/dashboard', function () {
    $stats = [
        'products'        => \App\Models\Product::count(),
        'categories'      => \App\Models\Category::count(),
        'slides'          => \App\Models\Slide::count(),
        'users'           => \App\Models\User::count(),
        'orders'          => \App\Models\Order::count(),
        'low_stock'       => \App\Models\Product::where('stock', '<=', 5)->count(),
        'active_products' => \App\Models\Product::where('is_active', true)->count(),
    ];
    $recent_products = \App\Models\Product::with('category')->latest()->take(5)->get();
    $recent_orders = \App\Models\Order::latest()->take(5)->get();
    return view('dashboard', compact('stats', 'recent_products', 'recent_orders'));
})->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('products', \App\Http\Controllers\ProductController::class)->middleware('auth');
Route::resource('categories', \App\Http\Controllers\CategoryController::class)->middleware('auth');
Route::resource('slides', \App\Http\Controllers\SlideController::class)->middleware('auth');
Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');
Route::resource('roles', \App\Http\Controllers\RoleController::class)->middleware('auth');
Route::resource('permissions', \App\Http\Controllers\PermissionController::class)->middleware('auth');

require __DIR__.'/auth.php';
