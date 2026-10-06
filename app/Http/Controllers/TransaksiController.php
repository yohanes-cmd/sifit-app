<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Gudang;
use App\Models\MasterObat;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // ===================== PEMASUKAN =====================

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
            'exp_date' => 'required|date',
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

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'master_obat_id' => $request->master_obat_id,
                'no_batch' => $request->no_batch,
                'exp_date' => $request->exp_date,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Pemasukan berhasil! Silakan cek database stok, pasti otomatis bertambah.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: '.$e->getMessage());
        }
    }

    // ===================== PENGELUARAN =====================

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

            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: '.$e->getMessage());
        }
    }

    // ===================== PEMINDAHAN =====================

    public function indexPemindahan()
    {
        $transaksis = Transaksi::with(['gudangAsal', 'gudangTujuan', 'detailTransaksis.masterObat', 'user'])
            ->where('jenis_transaksi', 'pemindahan')
            ->latest()
            ->get();

        return view('transaksi.pemindahan.index', compact('transaksis'));
    }

    public function createPemindahan()
    {
        $masterObats = MasterObat::orderBy('nama_obat')->get();
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
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.master_obat_id' => 'required|exists:master_obats,id',
            'items.*.no_batch' => 'required|string',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'gudang_tujuan_id.different' => 'Gudang tujuan tidak boleh sama dengan gudang asal.',
            'items.required' => 'Harap tambahkan minimal satu item pemindahan.',
            'items.*.master_obat_id.required' => 'Obat/logistik harus dipilih.',
            'items.*.no_batch.required' => 'Nomor batch wajib diisi.',
            'items.*.jumlah.required' => 'Jumlah wajib diisi.',
            'items.*.jumlah.min' => 'Jumlah minimal 1.',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => 'pemindahan',
                'gudang_asal_id' => $request->gudang_asal_id,
                'gudang_tujuan_id' => $request->gudang_tujuan_id,
                'catatan' => $request->catatan,
                'user_id' => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'master_obat_id' => $item['master_obat_id'],
                    'no_batch' => $item['no_batch'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->route('pemindahan.index')->with('success', 'Pemindahan barang berhasil disimpan! Cek Daftar Stok untuk melihat perubahannya.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal memproses pemindahan: '.$e->getMessage());
        }
    }

    public function showPemindahan(Transaksi $transaksi)
    {
        $transaksi->load(['gudangAsal', 'gudangTujuan', 'detailTransaksis.masterObat', 'user']);

        return view('transaksi.pemindahan.show', compact('transaksi'));
    }
}
