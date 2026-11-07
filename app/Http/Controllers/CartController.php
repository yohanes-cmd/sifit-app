<?php

namespace App\Http\Controllers;

use App\Models\MasterObat;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja / pengajuan obat
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('permohonan.create')->with('info', 'Fitur etalase publik dan keranjang ritel telah dinonaktifkan. Pengajuan kebutuhan obat dilakukan melalui formulir Permohonan Logistik Obat resmi.');
        }

        return redirect()->route('frontend.obat')->with('info', 'Fitur keranjang ritel telah dinonaktifkan. SIFIT berfokus pada distribusi logistik farmasi instansi.');
    }

    /**
     * Tambahkan obat ke keranjang
     */
    public function add(Request $request, $id)
    {
        if (auth()->check()) {
            return redirect()->route('permohonan.create')->with('info', 'Permohonan obat resmi diajukan langsung melalui menu Permohonan Obat.');
        }

        return redirect()->route('frontend.obat')->with('info', 'Fitur keranjang ritel telah dinonaktifkan. Sistem difokuskan pada distribusi logistik resmi.');
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
            $product = MasterObat::withSum('stokObats as total_stok', 'jumlah')->find($id);
            if ($product && $product->stock > 0 && $product->stock < $quantity) {
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
