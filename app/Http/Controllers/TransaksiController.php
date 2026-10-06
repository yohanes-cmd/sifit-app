<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Gudang;
use App\Models\MasterObat;
use App\Models\Pemasok;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // ===================== PEMASUKAN =====================

    public function indexPemasukan(Request $request)
    {
        $query = Transaksi::with(['gudangTujuan', 'pemasok', 'user'])
            ->withCount('detailTransaksis')
            ->where('jenis_transaksi', 'pemasukan')
            ->latest();

        if ($request->filled('gudang_id')) {
            $query->where('gudang_tujuan_id', $request->gudang_id);
        }

        $transaksis = $query->paginate(15)->withQueryString();
        $gudangs = Gudang::all();
        $selectedGudang = $request->gudang_id;

        return view('transaksi.pemasukan.index', compact('transaksis', 'gudangs', 'selectedGudang'));
    }

    public function createPemasukan()
    {
        $masterObats = MasterObat::orderBy('nama_obat')->get();
        $gudangs = Gudang::all();
        $pemasoks = Pemasok::orderBy('nama_pemasok')->get();

        return view('transaksi.pemasukan.create', compact('masterObats', 'gudangs', 'pemasoks'));
    }

    public function storePemasukan(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|string',
            'gudang_tujuan_id' => 'required|exists:gudangs,id',
            'pemasok_id' => 'nullable|exists:pemasoks,id',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.master_obat_id' => 'required|exists:master_obats,id',
            'items.*.no_batch' => 'required|string',
            'items.*.exp_date' => 'required|date',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => 'pemasukan',
                'gudang_asal_id' => null,
                'gudang_tujuan_id' => $request->gudang_tujuan_id,
                'pemasok_id' => $request->pemasok_id,
                'catatan' => $request->catatan,
                'user_id' => Auth::id(),
            ]);

            foreach ($request->items as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'master_obat_id' => $item['master_obat_id'],
                    'no_batch' => $item['no_batch'],
                    'exp_date' => $item['exp_date'],
                    'jumlah' => $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->route('pemasukan.index')->with('success', 'Transaksi Pemasukan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi: '.$e->getMessage());
        }
    }

    public function showPemasukan(Transaksi $transaksi)
    {
        $transaksi->load(['gudangTujuan', 'pemasok', 'user', 'detailTransaksis.masterObat']);

        return view('transaksi.pemasukan.show', compact('transaksi'));
    }

    public function destroyPemasukan(Transaksi $transaksi)
    {
        try {
            $transaksi->delete();

            return redirect()->route('pemasukan.index')->with('success', 'Data transaksi pemasukan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: '.$e->getMessage());
        }
    }

    public function bulkDeletePemasukan(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:transaksis,id',
        ]);

        try {
            Transaksi::whereIn('id', $request->ids)->delete();

            return redirect()->route('pemasukan.index')->with('success', count($request->ids).' data transaksi pemasukan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }

    public function showImportCsvPemasukan()
    {
        return view('transaksi.pemasukan.import_csv');
    }

    public function downloadTemplateCsvPemasukan()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_pemasukan.csv"',
        ];

        $columns = ['nomor_surat', 'tanggal', 'gudang_id', 'pemasok_id', 'kode_obat', 'no_batch', 'exp_date', 'jumlah', 'catatan'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['SURAT-001', date('Y-m-d'), '1', '1', 'OBT-001', 'BATCH-001', date('Y').'-12-31', '100', 'Pemasukan dari CSV']);
            fputcsv($file, ['SURAT-001', date('Y-m-d'), '1', '1', 'OBT-002', 'BATCH-002', date('Y').'-12-31', '50', '']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCsvPemasukan(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $file = fopen($path, 'r');
        $header = fgetcsv($file);

        if (! $header) {
            return redirect()->back()->with('error', 'File CSV kosong atau format tidak valid.');
        }

        DB::beginTransaction();
        try {
            $importedRows = 0;
            $skippedRows = 0;
            $currentNomorSurat = null;
            $currentTransaksi = null;

            while (($row = fgetcsv($file)) !== false) {
                // Skip baris yang terlalu pendek
                if (count($row) < 7) {
                    $skippedRows++;

                    continue;
                }

                $nomorSurat = trim($row[0]);
                $tanggal = trim($row[1]);
                $gudangId = trim($row[2]);
                $pemasokId = ! empty(trim($row[3])) ? trim($row[3]) : null;
                $kodeObat = trim($row[4]);
                $noBatch = trim($row[5]);
                $expDate = trim($row[6]);
                $jumlah = isset($row[7]) ? (int) trim($row[7]) : 1;
                $catatan = isset($row[8]) ? trim($row[8]) : null;

                // Cari master obat berdasarkan kode_obat
                $masterObat = MasterObat::where('kode_obat', $kodeObat)->first();
                if (! $masterObat) {
                    $skippedRows++;

                    continue; // Lewati baris jika kode_obat tidak ditemukan
                }

                // Buat transaksi baru hanya jika nomor_surat berbeda
                if ($currentNomorSurat !== $nomorSurat) {
                    $currentNomorSurat = $nomorSurat;
                    $currentTransaksi = Transaksi::create([
                        'nomor_surat' => $nomorSurat,
                        'tanggal' => $tanggal ?: now()->toDateString(),
                        'jenis_transaksi' => 'pemasukan',
                        'gudang_asal_id' => null,
                        'gudang_tujuan_id' => $gudangId ?: null,
                        'pemasok_id' => $pemasokId,
                        'catatan' => $catatan,
                        'user_id' => Auth::id(),
                    ]);
                }

                DetailTransaksi::create([
                    'transaksi_id' => $currentTransaksi->id,
                    'master_obat_id' => $masterObat->id,
                    'no_batch' => $noBatch,
                    'exp_date' => $expDate,
                    'jumlah' => $jumlah,
                ]);

                $importedRows++;
            }

            fclose($file);
            DB::commit();

            $message = "Berhasil mengimpor {$importedRows} item pemasukan dari file CSV.";
            if ($skippedRows > 0) {
                $message .= " {$skippedRows} baris dilewati (kode obat tidak ditemukan / format tidak valid).";
            }

            return redirect()->route('pemasukan.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($file);

            return redirect()->back()->with('error', 'Gagal mengimpor file CSV: '.$e->getMessage());
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
