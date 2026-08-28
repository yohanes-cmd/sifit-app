<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:product,news,information',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Mendukung format gambar & SVG
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'type'  => 'required|in:product,news,information',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}