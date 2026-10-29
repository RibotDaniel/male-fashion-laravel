<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

// 1. Vistas Públicas 
Route::get('/', function () {
    return view('index');
});

Route::get('/tienda', function () {
    return view('tienda');
});

Route::get('/ropa', [ProductController::class, 'indexRopa']);
Route::get('/calzado', function () { return view('calzado'); });
Route::get('/accesorios', function () { return view('accesorios'); });

// Ver el detalle individual de un producto (Público)
Route::get('/productos/{id}', [ProductController::class, 'show']);

// 2. Rutas Privadas (Requieren Iniciar Sesión)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile.edit');

    Route::get('/dashboard', function () {
        return redirect('/profile');
    })->name('dashboard');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestión de Productos (Crear, Editar, Eliminar)
    Route::post('/productos', [ProductController::class, 'store']);
    Route::put('/productos/{id}', [ProductController::class, 'update']);
    Route::delete('/productos/{id}', [ProductController::class, 'destroy']);
});

// 3. Panel Admin
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;

// Rutas del Carrito
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/eliminar', [CartController::class, 'remove'])->name('cart.remove');

// Rutas de Favoritos
Route::post('/favoritos/agregar', [FavoriteController::class, 'add'])->name('favorite.add');
Route::post('/favoritos/eliminar', [FavoriteController::class, 'remove'])->name('favorite.remove');
Route::post('/favoritos/al-carrito', [FavoriteController::class, 'moveToCart'])->name('favorite.toCart');

use App\Http\Controllers\CheckoutController;

// Rutas del Checkout / Proceso de Pago
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/procesar', [CheckoutController::class, 'process'])->name('checkout.process');



Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/procesar', [CheckoutController::class, 'process'])->name('checkout.process');
});

Route::get('/contacto', function () {
    return view('contacto');
});