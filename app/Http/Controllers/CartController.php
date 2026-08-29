<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan keranjang
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('user.cart', compact('cart'));
    }

    // Menambahkan menu ke keranjang
    public function add(Menu $menu, Request $request)
    {
        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['qty'] += $quantity;
        } else {
            $cart[$menu->id] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'image' => $menu->image,
                'qty' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu berhasil ditambahkan ke keranjang.',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    // Update jumlah menu
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            if ($request->action == 'plus') {
                $cart[$id]['qty']++;
            }

            if ($request->action == 'minus') {

                if ($cart[$id]['qty'] > 1) {
                    $cart[$id]['qty']--;
                }

            }

        }

        session()->put('cart', $cart);

        return redirect()->back();
    }

    // Hapus menu dari keranjang
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect()->back();
    }
}
