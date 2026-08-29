<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::query();

        // Search
        if (request('search')) {
            $search = request('search');
            $query->where('customer_name', 'like', '%'.$search.'%')
                ->orWhere('order_number', 'like', '%'.$search.'%')
                ->orWhere('phone', 'like', '%'.$search.'%');
        }

        // Paginate results
        $orders = $query->latest()->paginate(10);

        // Status
        $newOrders = Order::where('status', 'Menunggu')->count();
        $pendingOrders = Order::where('status', 'Diproses')->count();
        $shippedOrders = Order::where('status', 'Selesai')->count();

        // pendaopatan
        $totalRevenue = Order::whereDate('created_at', today())
            ->where('payment_status', 'Lunas')
            ->sum('total');

        return view('admin.orders.index', compact('orders', 'newOrders', 'pendingOrders', 'shippedOrders', 'totalRevenue'));
    }

    public function show(Order $order)
    {
        $order->load('items.menu');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required',
            'payment_status' => 'required',
        ]);

        // Jika baru saja diverifikasi
        if (
            $order->payment_status != 'Lunas'
            && $request->payment_status == 'Lunas'
        ) {

            foreach ($order->items as $item) {

                $menu = $item->menu;

                $menu->stock -= $item->qty;

                if ($menu->stock < 0) {
                    $menu->stock = 0;
                }

                $menu->save();

            }

        }

        $order->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }
}
