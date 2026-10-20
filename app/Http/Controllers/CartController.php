<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Agregar al Carrito
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'talla'      => 'required|string',
            'cantidad'   => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $cantidad = $request->cantidad ?? 1;
        $itemKey = $product->id . '_' . $request->talla;

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['cantidad'] += $cantidad;
        } else {
            $cart[$itemKey] = [
                'id'       => $product->id,
                'nombre'   => $product->nombre,
                'precio'   => $product->precio,
                'imagen'   => $product->imagen,
                'talla'    => $request->talla,
                'cantidad' => $cantidad,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('open_cart', true)->with('success', '¡Prenda agregada al carrito!');
    }

    // Eliminar del Carrito
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->item_key])) {
            unset($cart[$request->item_key]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('open_cart', true)->with('success', 'Prenda eliminada del carrito.');
    }
}