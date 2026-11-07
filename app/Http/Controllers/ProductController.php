<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterObat;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data produk beserta relasi kategori dan user penginput
        $products = Product::with(['category', 'user'])->latest()->get();

        // Mengirim data ke halaman view
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil kategori khusus produk untuk ditampilkan di dropdown form
        $categories = Category::where('type', 'product')->get();

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data dari form (Ditambah validasi 'unit')
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer',
            'status' => 'required|in:published,draft,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Ambil semua data inputan
        $data = $request->all();

        // 3. Buat slug otomatis dari nama obat (ditambah waktu agar unik)
        $data['slug'] = Str::slug($request->name).'-'.time();

        // 4. Catat ID admin yang sedang login secara dinamis
        $data['user_id'] = auth()->id();

        // 5. Cek apakah checkbox resep dokter dicentang (bernilai true) atau tidak (bernilai false)
        $data['requires_prescription'] = $request->has('requires_prescription') ? true : false;

        // 6. Proses upload gambar jika ada
        if ($request->hasFile('image')) {
            // Gambar akan disimpan di folder storage/app/public/products
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 7. Simpan ke database
        Product::create($data);

        // 8. Kembali ke halaman index dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('type', 'product')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer',
            'status' => 'required|in:published,draft,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Update slug jika nama berubah
        $data['slug'] = Str::slug($request->name).'-'.time();

        // Cek apakah checkbox dicentang (bernilai true) atau tidak (bernilai false)
        $data['requires_prescription'] = $request->has('requires_prescription') ? true : false;

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    /**
     * Methods untuk Frontend (Halaman Publik SiFit)
     */
    public function frontendIndex(Request $request)
    {
        $query = MasterObat::where(function ($q) {
            $q->where('status', 'published')->orWhereNull('status');
        })
            ->withSum('stokObats as total_stok', 'jumlah')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                    ->orWhere('kode_obat', 'like', "%{$search}%")
                    ->orWhere('kode_kemkes', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('kategori', $request->category);
        }

        $products = $query->paginate(9)->withQueryString();

        $categories = MasterObat::whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->pluck('kategori')
            ->map(function ($kat) {
                return (object) [
                    'id' => $kat,
                    'name' => $kat,
                ];
            });

        return view('frontend.obat.index', compact('products', 'categories'));
    }

    public function frontendShow($slug)
    {
        $product = MasterObat::where(function ($q) use ($slug) {
            $q->where('slug', $slug)->orWhere('id', $slug);
        })
            ->where(function ($q) {
                $q->where('status', 'published')->orWhereNull('status');
            })
            ->withSum('stokObats as total_stok', 'jumlah')
            ->first();

        if (! $product) {
            $parts = explode('-', (string) $slug);
            $lastPart = end($parts);
            if (is_numeric($lastPart)) {
                $product = MasterObat::where(function ($q) {
                    $q->where('status', 'published')->orWhereNull('status');
                })
                    ->withSum('stokObats as total_stok', 'jumlah')
                    ->find($lastPart);
            }
        }

        if (! $product) {
            abort(404);
        }

        $relatedQuery = MasterObat::where(function ($q) {
            $q->where('status', 'published')->orWhereNull('status');
        })
            ->where('id', '!=', $product->id)
            ->withSum('stokObats as total_stok', 'jumlah');

        if (! empty($product->kategori)) {
            $relatedQuery->where('kategori', $product->kategori);
        }

        $relatedProducts = $relatedQuery->latest()
            ->take(4)
            ->get();

        return view('frontend.obat.detail', compact('product', 'relatedProducts'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage sebelum datanya dihapus dari database
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Data obat berhasil dihapus!');
    }
}
