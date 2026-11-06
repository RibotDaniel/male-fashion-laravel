<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Models\Product;

// 1. Vistas Públicas 
Route::get('/', function () {
    return view('index');
});

Route::get('/tienda', function () {
    return view('tienda');
});

Route::get('/ropa', [ProductController::class, 'indexRopa']);

Route::get('/calzado', function () {
    $productos = Product::where('categoria', 'calzado')->get();
    return view('calzado', compact('productos'));
});

Route::get('/accesorios', function () {
    $productos = Product::where('categoria', 'accesorios')->get();
    return view('accesorios', compact('productos'));
});

Route::get('/contacto', function () {
    return view('contacto');
});

// Ver detalle de producto
Route::get('/productos/{id}', [ProductController::class, 'show']);

// Rutas del Carrito
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/eliminar', [CartController::class, 'remove'])->name('cart.remove');

// Rutas de Favoritos
Route::post('/favoritos/agregar', [FavoriteController::class, 'add'])->name('favorite.add');
Route::post('/favoritos/eliminar', [FavoriteController::class, 'remove'])->name('favorite.remove');
Route::post('/favoritos/al-carrito', [FavoriteController::class, 'moveToCart'])->name('favorite.toCart');

// 2. Rutas Privadas / Autenticadas
Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return redirect('/profile');
    })->name('dashboard');

    // Checkout / Proceso de Pago (Apuntando ÚNICAMENTE a CartController)
    Route::get('/checkout', [CartController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/procesar', [CartController::class, 'checkout'])->name('checkout.process');

    // Gestión de Productos por Admin
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