<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function index()
    {
        $cart = [];
        $cartTotal = 0;

        if (Auth::check()) {
            $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get();
            foreach ($cartItems as $item) {
                if ($item->product) {
                    $cart[] = [
                        'id'       => $item->product->id,
                        'nombre'   => $item->product->nombre,
                        'precio'   => $item->product->precio,
                        'imagen'   => $item->product->imagen,
                        'talla'    => $item->talla,
                        'cantidad' => $item->cantidad,
                    ];
                    $cartTotal += $item->product->precio * $item->cantidad;
                }
            }
        } else {
            $sessionCart = session()->get('cart', []);
            foreach ($sessionCart as $item) {
                $cart[] = $item;
                $cartTotal += $item['precio'] * $item['cantidad'];
            }
        }

        return view('checkout', compact('cart', 'cartTotal'));
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para finalizar tu compra.');
        }

        $cartItems = CartItem::where('user_id', Auth::id())->get();
        $sessionCart = session()->get('cart', []);
        $total = 0;

        // 1. Procesar descuento de inventario para ítems guardados en Base de Datos
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $total += $product->precio * $item->cantidad;
            }
            $this->ejecutarDescuento($item->product_id, $item->talla, $item->cantidad);
        }

        // 2. Procesar descuento de inventario para ítems guardados en Sesión
        foreach ($sessionCart as $item) {
            $total += $item['precio'] * $item['cantidad'];
            $this->ejecutarDescuento($item['id'], $item['talla'] ?? null, $item['cantidad']);
        }

        // 3. Generar la Orden
        Order::create([
            'user_id' => Auth::id(),
            'total'   => $total,
            'status'  => 'Completado',
        ]);

        // 4. Vaciar carritos tras la compra
        CartItem::where('user_id', Auth::id())->delete();
        session()->forget('cart');

        return redirect('/profile')->with('success', '¡Compra realizada con éxito! Tu pedido ha sido procesado.');
    }

    private function ejecutarDescuento($productId, $talla, $cantidad)
    {
        if (!$talla) {
            DB::statement("UPDATE products SET stock = GREATEST(0, stock - ?) WHERE id = ?", [$cantidad, $productId]);
            return;
        }

        $tallaLimpia = strtolower(trim((string)$talla));
        $columna = 'stock_' . $tallaLimpia;

        try {
            DB::statement("UPDATE products SET {$columna} = GREATEST(0, {$columna} - ?) WHERE id = ?", [$cantidad, $productId]);
        } catch (\Exception $e) {
            try {
                DB::statement("UPDATE products SET stock = GREATEST(0, stock - ?) WHERE id = ?", [$cantidad, $productId]);
            } catch (\Exception $ex) {
                // Silenciar en caso de no existir la columna stock
            }
        }
    }
}