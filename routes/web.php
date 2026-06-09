<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    if (Auth::user()->role === 'admin') {
        return app(AdminController::class)->dashboard();
    }

    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
});

Route::post('/register', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
        'role' => 'pembeli',
    ]);

    Auth::login($user);

    return redirect()->intended(route('home'));
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware(['auth', 'pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/add-to-cart', [CartController::class, 'store'])->name('cart.store');

    Route::get('/cart', [CartController::class, 'index'])->name('carts.index');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('carts.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);

    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
    Route::get('/rentals/{rental}/send-links', [RentalController::class, 'sendLinksForm'])->name('rentals.sendLinksForm');
    Route::post('/rentals/{rental}/send-links', [RentalController::class, 'sendLinks'])->name('rentals.sendLinks');
    Route::post('/rentals/{rental}/reject', [RentalController::class, 'reject'])->name('rentals.reject');
    Route::post('/rentals/{rental}/expire', [RentalController::class, 'expire'])->name('rentals.expire');
});
