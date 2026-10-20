<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // Mostrar pantalla de pago
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/ropa')->with('error', 'Tu carrito está vacío.');
        }

        $cartTotal = 0;
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

        // Vaciar el carrito tras confirmar la compra
        session()->forget('cart');

        return redirect('/ropa')->with('success', '¡Gracias por tu compra! Tu pedido ha sido procesado con éxito.');
    }
}