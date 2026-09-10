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
        // 1. Validasi ditambah exp_date
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|string',
            'gudang_tujuan_id' => 'required|exists:gudangs,id',
            'master_obat_id' => 'required|exists:master_obats,id',
            'no_batch' => 'required|string',
            'exp_date' => 'required|date', // Tambahan validasi Expired Date
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => 'pemasukan',
                'gudang_asal_id' => null, 
                'gudang_tujuan_id' => $request->gudang_tujuan_id,
                'user_id' => Auth::id(), 
            ]);

            // 2. Insert ke Detail Transaksi (Ditambah exp_date agar dibaca oleh Trigger)
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'master_obat_id' => $request->master_obat_id,
                'no_batch' => $request->no_batch,
                'exp_date' => $request->exp_date, // Menyimpan Expired Date
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pemasukan berhasil! Silakan cek database stok, pasti otomatis bertambah.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function createPengeluaran()
    {
        $masterObats = MasterObat::all();
        $gudangs = Gudang::all();
        return view('transaksi.pengeluaran.create', compact('masterObats', 'gudangs'));
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|string',
            'gudang_asal_id' => 'required|exists:gudangs,id', 
            'master_obat_id' => 'required|exists:master_obats,id',
            'no_batch' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => 'pengeluaran',
                'gudang_asal_id' => $request->gudang_asal_id, 
                'gudang_tujuan_id' => null, 
                'user_id' => Auth::id(),
            ]);

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'master_obat_id' => $request->master_obat_id,
                'no_batch' => $request->no_batch,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pengeluaran berhasil! Silakan cek halaman Daftar Stok, pasti jumlahnya otomatis berkurang.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function createPemindahan()
    {
        $masterObats = MasterObat::all();
        $gudangs = Gudang::all();
        return view('transaksi.pemindahan.create', compact('masterObats', 'gudangs'));
    }

    public function storePemindahan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|string',
            'gudang_asal_id' => 'required|exists:gudangs,id',
            'gudang_tujuan_id' => 'required|exists:gudangs,id|different:gudang_asal_id', 
            'master_obat_id' => 'required|exists:master_obats,id',
            'no_batch' => 'required|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => 'pemindahan',
                'gudang_asal_id' => $request->gudang_asal_id,
                'gudang_tujuan_id' => $request->gudang_tujuan_id,
                'user_id' => Auth::id(),
            ]);

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'master_obat_id' => $request->master_obat_id,
                'no_batch' => $request->no_batch,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pemindahan barang berhasil! Cek Daftar Stok untuk melihat perubahannya.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses pemindahan: ' . $e->getMessage());
        }
    }
}