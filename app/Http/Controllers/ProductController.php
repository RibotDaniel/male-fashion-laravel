<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function indexRopa()
    {
        $productos = Product::where('categoria', 'ropa')->get();
        return view('ropa', compact('productos'));
    }

    public function indexCalzado()
    {
        $productos = Product::where('categoria', 'calzado')->get();
        return view('calzado', compact('productos'));
    }

    public function indexAccesorios()
    {
        $productos = Product::where('categoria', 'accesorios')->get();
        return view('accesorios', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'precio'    => 'required|numeric',
            'imagen'    => 'required|string',
            'categoria' => 'required|string|in:ropa,calzado,accesorios',
        ]);

        Product::create([
            'nombre'    => $request->nombre,
            'precio'    => $request->precio,
            'imagen'    => $request->imagen,
            'categoria' => $request->categoria,
            
            'stock_s'   => $request->stock_s ?? 0,
            'stock_m'   => $request->stock_m ?? 0,
            'stock_l'   => $request->stock_l ?? 0,
            'stock_xl'  => $request->stock_xl ?? 0,

            'stock_26'  => $request->stock_26 ?? 0,
            'stock_27'  => $request->stock_27 ?? 0,
            'stock_28'  => $request->stock_28 ?? 0,
            'stock_29'  => $request->stock_29 ?? 0,

            'stock'     => $request->stock ?? 0,
        ]);

        return redirect()->back()->with('success', '¡Producto agregado al catálogo exitosamente!');
    }

    public function show($id)
    {
        $producto = Product::findOrFail($id);
        return view('detalle', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $producto = Product::findOrFail($id);

        $request->validate([
            'nombre'    => 'required|string|max:255',
            'precio'    => 'required|numeric',
            'imagen'    => 'required|string',
        ]);

        $producto->update([
            'nombre'    => $request->nombre,
            'precio'    => $request->precio,
            'imagen'    => $request->imagen,
            'stock_s'   => $request->stock_s ?? $producto->stock_s,
            'stock_m'   => $request->stock_m ?? $producto->stock_m,
            'stock_l'   => $request->stock_l ?? $producto->stock_l,
            'stock_xl'  => $request->stock_xl ?? $producto->stock_xl,
            'stock_26'  => $request->stock_26 ?? $producto->stock_26,
            'stock_27'  => $request->stock_27 ?? $producto->stock_27,
            'stock_28'  => $request->stock_28 ?? $producto->stock_28,
            'stock_29'  => $request->stock_29 ?? $producto->stock_29,
            'stock'     => $request->stock ?? $producto->stock,
        ]);

        return redirect()->back()->with('success', '¡Producto actualizado con éxito!');
    }

    public function destroy($id)
    {
        $producto = Product::findOrFail($id);
        $categoria = $producto->categoria;
        $producto->delete();

        return redirect('/' . $categoria)->with('success', '¡Producto eliminado del catálogo correctamente!');
    }
}