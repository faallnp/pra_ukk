<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;

class AdminController extends Controller
{
    public function index()
    {
        $totalMenu = Menu::count();

        $totalOrder = Order::count();

        $totalRevenue = Order::where('status', 'Selesai')->sum('total');

        $pendingOrder = Order::where('status', 'Menunggu')->count();

        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.index', compact(
            'totalMenu',
            'totalOrder',
            'totalRevenue',
            'pendingOrder',
            'recentOrders'
        ));
    }
}
