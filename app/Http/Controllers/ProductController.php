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

    // Guarda una nueva prenda desde el panel de admin
    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'precio'   => 'required|numeric',
            'imagen'   => 'required|string',
            'stock_s'  => 'nullable|integer|min:0',
            'stock_m'  => 'nullable|integer|min:0',
            'stock_l'  => 'nullable|integer|min:0',
            'stock_xl' => 'nullable|integer|min:0',
        ]);

        Product::create([
            'nombre'    => $request->nombre,
            'precio'    => $request->precio,
            'imagen'    => $request->imagen,
            'categoria' => 'ropa',
            'stock_s'   => $request->stock_s ?? 0,
            'stock_m'   => $request->stock_m ?? 0,
            'stock_l'   => $request->stock_l ?? 0,
            'stock_xl'  => $request->stock_xl ?? 0,
        ]);

        return redirect()->back()->with('success', '¡Prenda agregada al catálogo exitosamente!');
    }

    // Muestra la vista de detalle de una sola prenda
    public function show($id)
    {
        $producto = Product::findOrFail($id);
        return view('detalle', compact('producto'));
    }

    // Actualiza los datos de la prenda (Solo Admin)
    public function update(Request $request, $id)
    {
        $producto = Product::findOrFail($id);

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'precio'   => 'required|numeric',
            'imagen'   => 'required|string',
            'stock_s'  => 'nullable|integer|min:0',
            'stock_m'  => 'nullable|integer|min:0',
            'stock_l'  => 'nullable|integer|min:0',
            'stock_xl' => 'nullable|integer|min:0',
        ]);

        $producto->update([
            'nombre'   => $request->nombre,
            'precio'   => $request->precio,
            'imagen'   => $request->imagen,
            'stock_s'  => $request->stock_s ?? 0,
            'stock_m'  => $request->stock_m ?? 0,
            'stock_l'  => $request->stock_l ?? 0,
            'stock_xl' => $request->stock_xl ?? 0,
        ]);

        return redirect()->back()->with('success', '¡Producto actualizado con éxito!');
    }

    // Elimina la prenda del catálogo (Solo Admin)
    public function destroy($id)
    {
        $producto = Product::findOrFail($id);
        $producto->delete();

        return redirect('/ropa')->with('success', '¡Prenda eliminada del catálogo correctamente!');
    }
}