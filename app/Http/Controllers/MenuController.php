<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category');

        if (request('search')) {
            $menus->where('name', 'like', '%'.request('search').'%');
        }

        if (request('category')) {
            $menus->where('category_id', request('category'));
        }

        $menus = $menus->latest()->get();

        $categories = Category::all();

        return view('user.menu', compact('menus', 'categories'));
    }

    public function show(Menu $menu)
    {
        $menu->load('category');

        // Ambil 3 menu lain dari kategori yang sama
        $relatedMenus = Menu::where('category_id', $menu->category_id)
            ->where('id', '!=', $menu->id)
            ->take(3)
            ->get();

        return view('user.detail-menu', compact('menu', 'relatedMenus'));
    }
}
