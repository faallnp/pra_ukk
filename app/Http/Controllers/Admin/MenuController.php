<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();

        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.menu.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|in:available,sold_out',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_favorite' => 'nullable|boolean',
        ]);

        try {

            if ($request->hasFile('image')) {

                $file = $request->file('image');

                $filename = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('uploads/menu'), $filename);

                $validated['image'] = $filename;
            }

            $validated['is_favorite'] = $request->has('is_favorite') ? true : false;

            Menu::create($validated);

            return redirect()
                ->route('admin.menus.index')
                ->with('success', 'Menu berhasil ditambahkan.');

        } catch (\Exception $e) {

            dd($e->getMessage());

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();

        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|in:available,sold_out',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_favorite' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {

            if ($menu->image && file_exists(public_path('uploads/menu/'.$menu->image))) {
                unlink(public_path('uploads/menu/'.$menu->image));
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/menu'), $filename);

            $validated['image'] = $filename;
        }

        $validated['is_favorite'] = $request->has('is_favorite') ? true : false;

        $menu->update($validated);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Hapus gambar jika ada
        if ($menu->image && file_exists(public_path('uploads/menu/'.$menu->image))) {
            unlink(public_path('uploads/menu/'.$menu->image));
        }

        // Hapus data menu
        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
