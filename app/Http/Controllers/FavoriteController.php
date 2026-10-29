<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $favorites = session()->get('favorites', []);

        if (!isset($favorites[$product->id])) {
            $favorites[$product->id] = [
                'id'     => $product->id,
                'nombre' => $product->nombre,
                'precio' => $product->precio,
                'imagen' => $product->imagen,
            ];
            session()->put('favorites', $favorites);
        }

        return redirect()->back()->with('open_favorites', true)->with('success', '¡Guardado en Favoritos!');
    }

    public function remove(Request $request)
    {
        $favorites = session()->get('favorites', []);
        if (isset($favorites[$request->product_id])) {
            unset($favorites[$request->product_id]);
            session()->put('favorites', $favorites);
        }

        return redirect()->back()->with('open_favorites', true)->with('success', 'Eliminado de Favoritos.');
    }

    public function moveToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $favorites = session()->get('favorites', []);
        $cart = session()->get('cart', []);
        $itemKey = $product->id . '_M'; // Talla por defecto M

        if (isset($cart[$itemKey])) {
            $cart[$itemKey]['cantidad'] += 1;
        } else {
            $cart[$itemKey] = [
                'id'       => $product->id,
                'nombre'   => $product->nombre,
                'precio'   => $product->precio,
                'imagen'   => $product->imagen,
                'talla'    => 'M',
                'cantidad' => 1,
            ];
        }
        session()->put('cart', $cart);

        if (isset($favorites[$request->product_id])) {
            unset($favorites[$request->product_id]);
            session()->put('favorites', $favorites);
        }

        return redirect()->back()->with('open_cart', true)->with('success', '¡Producto movido al carrito!');
    }
}