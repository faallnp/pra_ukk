<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_favorite', true)->latest()->take(6)->get();

        return view('user.home', compact('menus'));
    }

    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->with('items')
            ->latest()
            ->get();

        return view('user.order-history', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== Auth::user()->id) {
            abort(403, 'Unauthorized');
        }

        $order->load('items.menu');

        return view('user.order-detail', compact('order'));
    }
}
