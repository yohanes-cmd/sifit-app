<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\MasterObat;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function createPemasukan()
    {
        $masterObats = MasterObat::all();
        $gudangs = Gudang::all();
        return view('transaksi.pemasukan.create', compact('masterObats', 'gudangs'));
    }

    public function storePemasukan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|string',
            'gudang_tujuan_id' => 'required|exists:gudangs,id',
            'master_obat_id' => 'required|exists:master_obats,id',
            'no_batch' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Gunakan DB Transaction agar aman jika terjadi error di tengah jalan
        DB::beginTransaction();
        try {
            // 1. Simpan Header Transaksi
            $transaksi = Transaksi::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => 'pemasukan',
                'gudang_asal_id' => null, // Karena barang dari luar
                'gudang_tujuan_id' => $request->gudang_tujuan_id,
                'user_id' => Auth::id(), // ID user yang sedang login
            ]);

            // 2. Simpan Detail Transaksi (Di sini Trigger MySQL akan otomatis menyala!)
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'master_obat_id' => $request->master_obat_id,
                'no_batch' => $request->no_batch,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();
            // Nanti kita arahkan ke halaman daftar stok, sementara kembali ke form dulu
            return redirect()->back()->with('success', 'Pemasukan berhasil! Silakan cek database stok, pasti otomatis bertambah.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}