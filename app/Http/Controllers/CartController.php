<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja / pengajuan obat
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $totalItems = 0;
        $hasPrescriptionItem = false;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
            $totalItems += $item['quantity'];
            if (! empty($item['requires_prescription'])) {
                $hasPrescriptionItem = true;
            }
        }

        return view('frontend.cart.index', compact('cart', 'total', 'totalItems', 'hasPrescriptionItem'));
    }

    /**
     * Tambahkan obat ke keranjang
     */
    public function add(Request $request, $id)
    {
        $product = Product::with('category')->where('status', 'published')->findOrFail($id);

        $quantity = (int) $request->input('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }

        // Cek batasan stok jika stok didefinisikan
        if ($product->stock !== null && $product->stock < $quantity) {
            return redirect()->back()->with('error', "Stok obat {$product->name} tidak mencukupi (tersedia: {$product->stock}).");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            if ($product->stock !== null && $product->stock < $newQuantity) {
                return redirect()->back()->with('error', "Jumlah melebihi stok yang tersedia (tersedia: {$product->stock}).");
            }
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->category ? $product->category->name : 'Umum',
                'price' => (float) $product->price,
                'unit' => $product->unit ?? 'Satuan',
                'image' => $product->image,
                'stock' => $product->stock,
                'requires_prescription' => (bool) $product->requires_prescription,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$product->name} berhasil ditambahkan ke keranjang!");
    }

    /**
     * Perbarui jumlah item di keranjang
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity <= 0) {
                unset($cart[$id]);
                session()->put('cart', $cart);

                return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
            }

            // Validasi batas stok
            $product = Product::find($id);
            if ($product && $product->stock !== null && $product->stock < $quantity) {
                return redirect()->back()->with('error', "Maksimum stok tersedia: {$product->stock}.");
            }

            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Jumlah obat di keranjang berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
    }

    /**
     * Hapus satu item dari keranjang
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Obat berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }

    /**
     * Kosongkan seluruh keranjang
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('frontend.cart.index')->with('success', 'Keranjang belanja berhasil dikosongkan.');
    }
}
