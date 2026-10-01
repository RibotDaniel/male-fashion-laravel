<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

// 1. Vistas Públicas Principales
Route::get('/', function () {
    return view('index');
});

Route::get('/tienda', function () {
    return view('tienda');
});

// 2. Rutas de Categorías de la Tienda (Conectadas a la Base de Datos)
Route::get('/ropa', [ProductController::class, 'indexRopa']);

Route::get('/calzado', function () {
    return view('calzado');
});

Route::get('/accesorios', function () {
    return view('accesorios');
});

// 3. Ruta de Perfil, Dashboard y Guardado de Productos (Autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile.edit');

    Route::get('/dashboard', function () {
        return redirect('/profile');
    })->name('dashboard');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Guardar prendas desde el formulario de la página web
    Route::post('/productos', [ProductController::class, 'store']);
});

// 4. Panel de Administración
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';