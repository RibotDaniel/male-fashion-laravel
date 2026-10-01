<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si su rol es 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Si es un cliente normal, lo redirige al inicio de la tienda
        return redirect('/')->with('error', 'No tienes permisos de administrador.');
    }
}