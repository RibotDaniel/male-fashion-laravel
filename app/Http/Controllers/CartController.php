<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'talla'      => 'required|string',
            'cantidad'   => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cantidad = $request->cantidad ?? 1;

        if (Auth::check()) {

            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->where('talla', $request->talla)
                ->first();

            if ($cartItem) {
                $cartItem->increment('cantidad', $cantidad);
            } else {
                CartItem::create([
                    'user_id'    => Auth::id(),
                    'product_id' => $product->id,
                    'talla'      => $request->talla,
                    'cantidad'   => $cantidad,
                ]);
            }
        } else {
            $cart = session()->get('cart', []);
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
        }

        return redirect()->back()->with('open_cart', true)->with('success', '¡Prenda agregada al carrito!');
    }

    public function remove(Request $request)
    {
        if (Auth::check()) {
            if ($request->has('cart_item_id')) {
                CartItem::where('id', $request->cart_item_id)
                    ->where('user_id', Auth::id())
                    ->delete();
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->item_key])) {
                unset($cart[$request->item_key]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->back()->with('open_cart', true)->with('success', 'Prenda eliminada del carrito.');
    }
}