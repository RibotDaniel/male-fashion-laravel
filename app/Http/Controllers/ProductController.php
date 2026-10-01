<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Muestra las prendas guardadas en la base de datos
    public function indexRopa()
    {
        $productos = Product::where('categoria', 'ropa')->get();
        return view('ropa', compact('productos'));
    }

    // Guarda una nueva prenda desde la página web
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'imagen' => 'required|url',
        ]);

        Product::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'imagen' => $request->imagen,
            'categoria' => 'ropa',
        ]);

        return redirect()->back()->with('success', '¡Prenda agregada al catálogo exitosamente!');
    }
}