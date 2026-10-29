<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Order; // <-- 1. IMPORTANTE: Importar el modelo Order
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Mostrar pantalla de pago
    public function index()
    {
        $cart = [];
        $cartTotal = 0;

        if (Auth::check()) {
            // Cargar carrito desde la base de datos para usuarios autenticados
            $dbCart = CartItem::with('product')->where('user_id', Auth::id())->get();
            foreach ($dbCart as $item) {
                if ($item->product) {
                    $key = $item->product_id . '_' . $item->talla;
                    $cart[$key] = [
                        'cart_item_id' => $item->id,
                        'id'           => $item->product_id,
                        'nombre'       => $item->product->nombre,
                        'precio'       => $item->product->precio,
                        'imagen'       => $item->product->imagen,
                        'talla'        => $item->talla,
                        'cantidad'     => $item->cantidad,
                    ];
                }
            }
        } else {
            // Cargar carrito desde la sesión para invitados
            $cart = session()->get('cart', []);
        }

        // Si el carrito sigue vacío, redirige a /ropa
        if (empty($cart)) {
            return redirect('/ropa')->with('error', 'Tu carrito está vacío.');
        }

        foreach ($cart as $item) {
            $cartTotal += $item['precio'] * $item['cantidad'];
        }

        return view('checkout', compact('cart', 'cartTotal'));
    }

    // Procesar el pago y finalizar pedido
    public function process(Request $request)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'direccion'     => 'required|string|max:255',
            'ciudad'        => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:10',
            'telefono'      => 'required|string|max:20',
            'metodo_pago'   => 'required|string',
        ]);

        // Calcular el total del carrito actual antes de vaciarlo
        $cartTotal = 0;
        if (Auth::check()) {
            $dbCart = CartItem::with('product')->where('user_id', Auth::id())->get();
            foreach ($dbCart as $item) {
                if ($item->product) {
                    $cartTotal += $item->product->precio * $item->cantidad;
                }
            }

            // 2. CREAR EL PEDIDO EN LA BASE DE DATOS PARA EL USUARIO AUTENTICADO
            if ($cartTotal > 0) {
                Order::create([
                    'user_id' => Auth::id(),
                    'total'   => $cartTotal,
                    'status'  => 'En camino'
                ]);
            }

            // Vaciar el carrito del usuario en la base de datos
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            // Si es invitado (opcionalmente podrías pedir que inicie sesión para guardar el pedido)
            session()->forget('cart');
        }

        // Redirigir al perfil o a la tienda con mensaje de éxito
        return redirect('/profile')->with('success', '¡Gracias por tu compra! Tu pedido ha sido registrado con éxito.');
    }
}