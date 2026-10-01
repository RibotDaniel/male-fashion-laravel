<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

// 1. Vistas Públicas (Libres para todo visitante)
Route::get('/', function () {
    return view('index');
});

Route::get('/tienda', function () {
    return view('tienda');
});

Route::get('/ropa', [ProductController::class, 'indexRopa']);
Route::get('/calzado', function () { return view('calzado'); });
Route::get('/accesorios', function () { return view('accesorios'); });

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

    Route::post('/productos', [ProductController::class, 'store']);
});

// 3. Panel Admin
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';