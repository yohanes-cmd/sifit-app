<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data produk beserta relasi kategori dan user penginput
        $products = \App\Models\Product::with(['category', 'user'])->latest()->get();

        // Mengirim data ke halaman view
        return view('products.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil kategori khusus produk untuk ditampilkan di dropdown form
        $categories = \App\Models\Category::where('type', 'product')->get();

        return view('products.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        // 1. Validasi data dari form
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'status'      => 'required|in:published,draft,inactive',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil semua data inputan
        $data = $request->all();

        // 3. Buat slug otomatis dari nama obat (ditambah waktu agar unik)
        $data['slug'] = \Illuminate\Support\Str::slug($request->name) . '-' . time();

        // 4. Catat siapa user/admin yang sedang login
        $data['user_id'] = auth()->id() ?? 1;

        // 5. Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Gambar akan disimpan di folder storage/app/public/products
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 6. Simpan ke database
        \App\Models\Product::create($data);

        // 7. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Data obat berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::where('type', 'product')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric',
            'unit'        => 'required|string|max:50',
            'stock'       => 'required|integer',
            'status'      => 'required|in:published,draft,inactive',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        // Update slug jika nama berubah
        $data['slug'] = \Illuminate\Support\Str::slug($request->name) . '-' . time();
        // Cek apakah checkbox dicentang (bernilai true) atau tidak (bernilai false)
        $data['requires_prescription'] = $request->has('requires_prescription') ? true : false;

        // ... (kode slug dan upload gambar tetap sama di bawahnya)

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    public function frontendIndex(Request $request)
    {
        $query = \App\Models\Product::with(['category', 'user'])
            ->where('status', 'published')
            ->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(9)->withQueryString();

        $categories = \App\Models\Category::where('type', 'product')->get();

        return view('frontend.obat.index', compact('products', 'categories'));
    }

    public function frontendShow($slug)
    {
        $product = \App\Models\Product::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedProducts = \App\Models\Product::with('category')
            ->where('status', 'published')
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.obat.detail', compact('product', 'relatedProducts'));
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);

        // Hapus gambar dari storage sebelum datanya dihapus dari database
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Data obat berhasil dihapus!');
    }
}
