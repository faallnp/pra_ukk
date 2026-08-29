<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $user = Auth::user();

        return view('user.checkout', compact('cart', 'total', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'delivery_method' => 'required|in:Ambil Sendiri,Di Antar',
        ]);

        if (count(session('cart', [])) == 0) {
            return redirect()->route('checkout.index');
        }

        $shipping_cost = ($request->delivery_method === 'Di Antar') ? 15000 : 0;

        session([
            'checkout' => [
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'delivery_method' => $request->delivery_method,
                'shipping_cost' => $shipping_cost,
            ],
        ]);

        return redirect()->route('payment');
    }

    public function payment()
    {
        $checkout = session('checkout');

        if (! $checkout) {
            return redirect()->route('checkout.index');
        }

        $cart = session('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['qty'];
        }

        $shipping_cost = $checkout['shipping_cost'] ?? 0;
        $total = $subtotal + $shipping_cost;

        return view('user.payment', compact('checkout', 'cart', 'subtotal', 'shipping_cost', 'total'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $checkout = session('checkout');
        $cart = session('cart', []);

        if (! $checkout || count($cart) == 0) {
            return redirect()->route('cart.index');
        }

        DB::beginTransaction();

        try {

            $file = $request->file('payment_proof');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/payment'), $filename);

            $total = 0;

            foreach ($cart as $item) {
                $total += $item['price'] * $item['qty'];
            }

            $shipping_cost = $checkout['shipping_cost'] ?? 0;

            $order = Order::create([
                'customer_name' => $checkout['customer_name'],
                'phone' => $checkout['phone'],
                'address' => $checkout['address'],
                'delivery_method' => $checkout['delivery_method'],
                'user_id' => Auth::user()->id ?? null,
                'total' => $total + $shipping_cost,
                'shipping_cost' => $shipping_cost,
                'status' => 'Menunggu',

                'payment_method' => 'QRIS',
                'payment_status' => 'Menunggu Verifikasi',
                'payment_proof' => $filename,
            ]);

            foreach ($cart as $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['id'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['qty'],
                ]);

            }

            DB::commit();

            session()->forget('cart');
            session()->forget('checkout');

            return redirect()->route('payment.success', $order->id);

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', $e->getMessage());

        }
    }

    public function success(Order $order)
    {
        return view('user.payment-success', compact('order'));
    }

    public function directCheckout($menuId, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($menuId);

        if ($menu->status === 'sold_out' || $menu->stock < $request->quantity) {
            return back()->with('error', 'Stok menu tidak cukup.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += $request->quantity;
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'image' => $menu->image,
                'qty' => $request->quantity,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('checkout.index');
    }
}
