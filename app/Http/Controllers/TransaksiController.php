<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Gudang;
use App\Models\MasterObat;
use App\Models\Opd;
use App\Models\Pemasok;
use App\Models\Pengangkut;
use App\Models\Permohonan;
use App\Models\Program;
use App\Models\StokObat;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // ===================== PEMASUKAN =====================

    public function indexPemasukan(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $isOpd = $user && $user->isAdminOpd();

        $query = Transaksi::latest();

        if ($isOpd) {
            // Untuk Admin OPD: Menampilkan seluruh obat masuk ke OPD dari SBBK Pusat (realisasi permohonan) dan penerimaan langsung
            $query->with(['gudangAsal', 'user', 'permohonan'])
                ->withCount('detailTransaksis')
                ->where('instansi_id', $user->opd_id)
                ->where(function ($q) {
                    $q->where('jenis_transaksi', 'pengeluaran') // SBBK dari Gudang Pusat yang ditujukan ke OPD ini
                        ->orWhere('jenis_transaksi', 'pemasukan');
                });

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('catatan', 'like', "%{$search}%")
                        ->orWhereHas('permohonan', function ($pq) use ($search) {
                            $pq->where('nomor_permohonan', 'like', "%{$search}%");
                        });
                });
            }
        } else {
            // Untuk Super Admin: Menampilkan pemasukan obat dari pemasok luar ke gudang pusat
            $query->with(['gudangTujuan', 'pemasok', 'user'])
                ->withCount('detailTransaksis')
                ->where('jenis_transaksi', 'pemasukan');

            if ($request->filled('gudang_id')) {
                $query->where('gudang_tujuan_id', $request->gudang_id);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nomor_surat', 'like', "%{$search}%")
                        ->orWhere('catatan', 'like', "%{$search}%")
                        ->orWhereHas('pemasok', function ($pq) use ($search) {
                            $pq->where('nama_pemasok', 'like', "%{$search}%");
                        });
                });
            }
        }

        $transaksis = $query->paginate(15)->withQueryString();
        $gudangs = Gudang::all();
        $selectedGudang = $request->gudang_id;

        return view('transaksi.pemasukan.index', compact('transaksis', 'gudangs', 'selectedGudang', 'isOpd'));
    }

    public function createPemasukan()
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user && ! $user->isSuperAdmin()) {
            abort(403, 'Pengelolaan pemasukan stok obat dari pemasok hanya dapat diakses oleh Super Admin Gudang Pusat.');
        }

        $masterObats = MasterObat::orderBy('nama_obat')->get();
        $gudangs = Gudang::all();
        $pemasoks = Pemasok::orderBy('nama_pemasok')->get();

        return view('transaksi.pemasukan.create', compact('masterObats', 'gudangs', 'pemasoks'));
    }

    public function storePemasukan(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user && ! $user->isSuperAdmin()) {
            abort(403, 'Pengelolaan pemasukan stok obat dari pemasok hanya dapat diakses oleh Super Admin Gudang Pusat.');
        }

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
        /** @var User $user */
        $user = Auth::user();
        $isOpd = $user && $user->isAdminOpd();

        if ($isOpd && $transaksi->instansi_id != $user->opd_id && $transaksi->user_id != $user->id) {
            abort(403, 'Anda tidak memiliki hak untuk melihat data pemasukan ini.');
        }

        $transaksi->load(['gudangAsal', 'gudangTujuan', 'pemasok', 'user', 'instansi', 'permohonan.opd', 'detailTransaksis.masterObat']);

        return view('transaksi.pemasukan.show', compact('transaksi', 'isOpd'));
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

                $masterObat = MasterObat::where('kode_obat', $kodeObat)->first();
                if (! $masterObat) {
                    $skippedRows++;

                    continue;
                }

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

    public function indexPengeluaran(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Transaksi::with(['gudangAsal', 'program', 'pengangkut', 'instansi', 'user'])
            ->withCount('detailTransaksis')
            ->where('jenis_transaksi', 'pengeluaran')
            ->latest();

        // Jika user adalah Admin OPD, hanya tampilkan dokumen SBBK yang ditujukan ke instansinya
        if ($user && $user->isAdminOpd()) {
            $userOpdId = $user->opd_id;
            if (! $userOpdId && $user->opd) {
                $opdObj = Opd::where('nama_opd', $user->opd)->first();
                $userOpdId = $opdObj?->id;
            }
            $query->where('instansi_id', $userOpdId ?? 0);
        }

        if ($request->filled('gudang_id')) {
            $query->where('gudang_asal_id', $request->gudang_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%")
                    ->orWhereHas('instansi', function ($iq) use ($search) {
                        $iq->where('nama_opd', 'like', "%{$search}%");
                    })
                    ->orWhereHas('program', function ($pq) use ($search) {
                        $pq->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        $transaksis = $query->paginate(15)->withQueryString();
        $gudangs = Gudang::all();
        $selectedGudang = $request->gudang_id;
        $isOpd = $user && $user->isAdminOpd();

        return view('transaksi.pengeluaran.index', compact('transaksis', 'gudangs', 'selectedGudang', 'isOpd'));
    }

    public function getStokByGudang(Gudang $gudang)
    {
        $stocks = StokObat::with('masterObat')
            ->where('gudang_id', $gudang->id)
            ->where('jumlah', '>', 0)
            ->orderBy('exp_date', 'asc')
            ->get()
            ->map(function ($stok) {
                $obat = $stok->masterObat;

                return [
                    'stok_id' => $stok->id,
                    'master_obat_id' => $stok->master_obat_id,
                    'nama_obat' => $obat->nama_obat ?? $stok->nama_obat_logistik ?? '-',
                    'kode_obat' => $obat->kode_obat ?? $stok->kode_obat_logistik ?? '-',
                    'kategori' => $obat->kategori ?? $stok->kategori ?? 'Obat',
                    'kode_kemkes' => $obat->kode_kemkes ?? null,
                    'no_batch' => $stok->no_batch,
                    'exp_date' => $stok->exp_date ? $stok->exp_date->format('Y-m-d') : null,
                    'exp_date_formatted' => $stok->exp_date ? $stok->exp_date->format('d/m/Y') : '-',
                    'jumlah' => (int) $stok->jumlah,
                    'satuan' => $stok->satuan ?: ($obat->satuan ?? 'Pcs'),
                    'harga_satuan' => (float) ($stok->harga_satuan > 0 ? $stok->harga_satuan : ($obat->harga ?? 0)),
                ];
            });

        return response()->json([
            'gudang' => [
                'id' => $gudang->id,
                'nama' => $gudang->nama_gudang,
            ],
            'stocks' => $stocks,
        ]);
    }

    public function createPengeluaran(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $isOpd = $user && $user->isAdminOpd();

        $masterObats = MasterObat::where('status', '!=', 'inactive')->orderBy('nama_obat')->get();
        if ($masterObats->isEmpty()) {
            $masterObats = MasterObat::orderBy('nama_obat')->get();
        }

        if ($isOpd) {
            // Admin OPD: Form pengeluaran obat pelayanan fasilitas (ke pasien, poli, IGD, atau pustu)
            $nomorSuratOtomatis = 'OUT-OPD-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -4));

            return view('transaksi.pengeluaran.create_opd', compact('masterObats', 'nomorSuratOtomatis'));
        }

        // Super Admin: Form SBBK Gudang Pusat
        $gudangs = Gudang::all();
        $programs = Program::orderBy('nama')->get();
        $pengangkuts = Pengangkut::orderBy('nama')->get();
        $instansis = Opd::orderBy('nama_opd')->get();

        // Ambil daftar permohonan yang siap direalisasikan (disetujui atau menunggu)
        $permohonanList = Permohonan::with(['opd', 'detailPermohonans.masterObat'])
            ->whereIn('status', ['disetujui', 'diproses', 'menunggu'])
            ->doesntHave('transaksi')
            ->latest('tanggal_permohonan')
            ->get();

        $selectedPermohonan = null;
        if ($request->filled('permohonan_id')) {
            $selectedPermohonan = Permohonan::with(['opd', 'detailPermohonans.masterObat'])->find($request->permohonan_id);
        }

        return view('transaksi.pengeluaran.create', compact(
            'masterObats',
            'gudangs',
            'programs',
            'pengangkuts',
            'instansis',
            'permohonanList',
            'selectedPermohonan'
        ));
    }

    public function storePengeluaran(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Logika Pengeluaran Obat untuk Admin OPD (Penyaluran ke Pasien / Unit Pelayanan / Pustu)
        if ($user && $user->isAdminOpd()) {
            $request->validate([
                'tanggal' => 'required|date',
                'nomor_surat' => 'required|string|max:255',
                'tujuan_pengeluaran' => 'required|string|max:255',
                'catatan' => 'nullable|string',
                'items' => 'required|array|min:1',
                'items.*.master_obat_id' => 'required|exists:master_obats,id',
                'items.*.jumlah' => 'required|integer|min:1',
            ], [
                'tujuan_pengeluaran.required' => 'Tujuan/Penerima pengeluaran wajib diisi (contoh: Poli Umum, IGD, Pustu, Pasien).',
                'items.required' => 'Minimal satu item obat harus ditambahkan.',
                'items.*.master_obat_id.required' => 'Pilih obat yang akan dikeluarkan.',
                'items.*.jumlah.required' => 'Jumlah obat wajib diisi.',
                'items.*.jumlah.min' => 'Jumlah obat minimal 1.',
            ]);

            DB::beginTransaction();
            try {
                $transaksi = Transaksi::create([
                    'nomor_surat' => $request->nomor_surat,
                    'tanggal' => $request->tanggal,
                    'jenis_transaksi' => 'pengeluaran',
                    'gudang_asal_id' => null,
                    'gudang_tujuan_id' => null,
                    'instansi_id' => $user->opd_id,
                    'user_id' => $user->id,
                    'catatan' => 'Penerima / Keperluan: '.$request->tujuan_pengeluaran.($request->catatan ? ' - '.$request->catatan : ''),
                ]);

                foreach ($request->items as $item) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'master_obat_id' => $item['master_obat_id'],
                        'no_batch' => ! empty($item['no_batch']) ? trim($item['no_batch']) : '-',
                        'exp_date' => ! empty($item['exp_date']) ? $item['exp_date'] : null,
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => 0,
                    ]);
                }

                DB::commit();

                return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran obat pelayanan OPD berhasil disimpan!');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->withInput()->with('error', 'Gagal memproses pengeluaran: '.$e->getMessage());
            }
        }

        // 2. Logika SBBK Resmi Gudang Pusat untuk Super Admin

        $request->validate([
            'tanggal' => 'required|date',
            'nomor_surat' => 'required|string|max:255',
            'permohonan_id' => 'nullable|exists:permohonans,id',
            'gudang_id' => 'required|exists:gudangs,id',
            'program_id' => 'required|exists:programs,id',
            'pengangkut_id' => 'required|exists:pengangkuts,id',
            'instansi_id' => 'required|exists:opds,id',
            'pajak_invoice' => 'required|in:NO TAX,VAT,GST',
            'biaya_kirim' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'master_obat_id' => 'required|array|min:1',
            'master_obat_id.*' => 'required|exists:master_obats,id',
            'no_batch' => 'required|array|min:1',
            'no_batch.*' => 'required|string',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ], [
            'master_obat_id.required' => 'Minimal satu item harus ditambahkan.',
            'master_obat_id.*.required' => 'Item obat/logistik wajib dipilih.',
            'no_batch.*.required' => 'Nomor batch wajib diisi untuk setiap item.',
            'jumlah.*.required' => 'Jumlah barang keluar wajib diisi.',
            'jumlah.*.min' => 'Jumlah barang keluar minimal 1.',
            'harga_satuan.*.required' => 'Harga satuan wajib diisi.',
            'harga_satuan.*.min' => 'Harga satuan minimal 0.',
        ]);

        // Verifikasi ketersediaan stok di gudang dan batch sebelum transaksi
        $groupedRequests = [];
        foreach ($request->master_obat_id as $index => $obatId) {
            $batch = trim($request->no_batch[$index] ?? '');
            $qty = (int) ($request->jumlah[$index] ?? 0);

            $stok = StokObat::where('gudang_id', $request->gudang_id)
                ->where('master_obat_id', $obatId)
                ->where('no_batch', $batch)
                ->first();

            $obat = MasterObat::find($obatId);
            $namaObat = $obat ? $obat->nama_obat : "ID {$obatId}";

            if (! $stok) {
                return redirect()->back()->withInput()->with('error', "Stok untuk '{$namaObat}' dengan Batch '{$batch}' tidak ditemukan di gudang ini.");
            }

            $key = $obatId.'__'.$batch;
            if (! isset($groupedRequests[$key])) {
                $groupedRequests[$key] = [
                    'nama_obat' => $namaObat,
                    'batch' => $batch,
                    'sisa_stok' => (int) $stok->jumlah,
                    'requested_total' => 0,
                    'exp_date' => $stok->exp_date,
                    'stok_model' => $stok,
                ];
            }
            $groupedRequests[$key]['requested_total'] += $qty;
        }

        // Cek apakah total permintaan melebihi sisa stok fisik
        foreach ($groupedRequests as $group) {
            if ($group['requested_total'] > $group['sisa_stok']) {
                return redirect()->back()->withInput()->with('error', "Stok tidak mencukupi untuk '{$group['nama_obat']}' (Batch: {$group['batch']}). Stok fisik tersedia: {$group['sisa_stok']}, total dikeluarkan pada form ini: {$group['requested_total']}.");
            }
        }

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'nomor_surat' => $request->nomor_surat,
                'tanggal' => $request->tanggal,
                'jenis_transaksi' => 'pengeluaran',
                'permohonan_id' => $request->permohonan_id,
                'gudang_asal_id' => $request->gudang_id,
                'gudang_tujuan_id' => null,
                'program_id' => $request->program_id,
                'pengangkut_id' => $request->pengangkut_id,
                'instansi_id' => $request->instansi_id,
                'pajak_invoice' => $request->pajak_invoice,
                'biaya_kirim' => $request->biaya_kirim ?? 0,
                'catatan' => $request->catatan,
                'user_id' => Auth::id(),
            ]);

            foreach ($request->master_obat_id as $index => $obatId) {
                $batch = trim($request->no_batch[$index]);
                $key = $obatId.'__'.$batch;
                $expDate = $groupedRequests[$key]['exp_date'] ?? null;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'master_obat_id' => $obatId,
                    'no_batch' => $batch,
                    'exp_date' => $expDate,
                    'jumlah' => $request->jumlah[$index],
                    'harga_satuan' => $request->harga_satuan[$index],
                ]);
            }

            // Jika transaksi berasal dari permohonan OPD, perbarui status permohonan menjadi selesai
            if ($request->filled('permohonan_id')) {
                Permohonan::where('id', $request->permohonan_id)->update([
                    'status' => 'selesai',
                ]);
            }

            DB::commit();

            return redirect()->route('pengeluaran.show', $transaksi->id)->with('success', 'Transaksi Pengeluaran (SBBK) berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi pengeluaran: '.$e->getMessage());
        }
    }

    public function showPengeluaran(Transaksi $transaksi)
    {
        $transaksi->load(['gudangAsal', 'program', 'pengangkut', 'instansi', 'user', 'permohonan', 'detailTransaksis.masterObat']);

        return view('transaksi.pengeluaran.show', compact('transaksi'));
    }

    public function destroyPengeluaran(Transaksi $transaksi)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user && $user->isAdminOpd()) {
            if ($transaksi->instansi_id != $user->opd_id || ! is_null($transaksi->gudang_asal_id)) {
                abort(403, 'Anda tidak memiliki hak untuk menghapus dokumen pengeluaran resmi Gudang Pusat.');
            }
        } elseif ($user && ! $user->isSuperAdmin()) {
            abort(403, 'Penghapusan transaksi pengeluaran hanya dapat dilakukan oleh Super Admin Gudang Pusat atau Admin OPD terkait.');
        }

        try {
            $permohonanId = $transaksi->permohonan_id;
            $transaksi->delete();

            // Kembalikan status permohonan menjadi disetujui jika transaksi pengeluaran dibatalkan/dihapus
            if ($permohonanId) {
                Permohonan::where('id', $permohonanId)->update([
                    'status' => 'disetujui',
                ]);
            }

            return redirect()->route('pengeluaran.index')->with('success', 'Data transaksi pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi pengeluaran: '.$e->getMessage());
        }
    }

    public function bulkDeletePengeluaran(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user && ! $user->isSuperAdmin()) {
            abort(403, 'Penghapusan transaksi pengeluaran hanya dapat dilakukan oleh Super Admin Gudang Pusat.');
        }

        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:transaksis,id',
        ]);

        try {
            $transaksis = Transaksi::whereIn('id', $request->ids)->get();
            foreach ($transaksis as $trx) {
                $trx->delete();
            }

            return redirect()->route('pengeluaran.index')->with('success', count($request->ids).' data transaksi pengeluaran berhasil dihapus. Seluruh stok dikembalikan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: '.$e->getMessage());
        }
    }

    // ===================== PEMINDAHAN =====================

    public function indexPemindahan()
    {
        /** @var User $user */
        $user = Auth::user();
        $isOpd = $user && $user->isAdminOpd();

        $query = Transaksi::with(['gudangAsal', 'gudangTujuan', 'detailTransaksis.masterObat', 'user'])
            ->where('jenis_transaksi', 'pemindahan')
            ->latest();

        if ($isOpd) {
            $query->where(function ($q) use ($user) {
                $q->where('instansi_id', $user->opd_id)
                    ->orWhere('user_id', $user->id);
            });
        }

        $transaksis = $query->get();

        return view('transaksi.pemindahan.index', compact('transaksis', 'isOpd'));
    }

    public function createPemindahan()
    {
        /** @var User $user */
        $user = Auth::user();
        $isOpd = $user && $user->isAdminOpd();

        $masterObats = MasterObat::where('status', '!=', 'inactive')->orderBy('nama_obat')->get();
        if ($masterObats->isEmpty()) {
            $masterObats = MasterObat::orderBy('nama_obat')->get();
        }

        if ($isOpd) {
            // Admin OPD: Form pemindahan/mutasi internal fasilitas OPD (antar ruangan/kamar obat/pustu)
            $nomorSuratOtomatis = 'MUT-OPD-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -4));

            return view('transaksi.pemindahan.create_opd', compact('masterObats', 'nomorSuratOtomatis'));
        }

        // Super Admin: Form pemindahan antar gudang pusat
        $gudangs = Gudang::all();

        return view('transaksi.pemindahan.create', compact('masterObats', 'gudangs'));
    }

    public function storePemindahan(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // 1. Mutasi Internal untuk Admin OPD
        if ($user && $user->isAdminOpd()) {
            $request->validate([
                'tanggal' => 'required|date',
                'nomor_surat' => 'required|string|max:255',
                'unit_asal' => 'required|string|max:255',
                'unit_tujuan' => 'required|string|max:255',
                'catatan' => 'nullable|string',
                'items' => 'required|array|min:1',
                'items.*.master_obat_id' => 'required|exists:master_obats,id',
                'items.*.jumlah' => 'required|integer|min:1',
            ], [
                'unit_asal.required' => 'Unit/Kamar obat asal wajib diisi (contoh: Gudang Obat Induk).',
                'unit_tujuan.required' => 'Unit/Ruangan tujuan wajib diisi (contoh: Apotek Rawat Jalan, IGD, Pustu).',
                'items.required' => 'Minimal satu item obat harus ditambahkan.',
                'items.*.master_obat_id.required' => 'Obat wajib dipilih.',
                'items.*.jumlah.required' => 'Jumlah wajib diisi.',
                'items.*.jumlah.min' => 'Jumlah minimal 1.',
            ]);

            DB::beginTransaction();
            try {
                $transaksi = Transaksi::create([
                    'nomor_surat' => $request->nomor_surat,
                    'tanggal' => $request->tanggal,
                    'jenis_transaksi' => 'pemindahan',
                    'gudang_asal_id' => null,
                    'gudang_tujuan_id' => null,
                    'instansi_id' => $user->opd_id,
                    'user_id' => $user->id,
                    'catatan' => 'Mutasi Internal OPD: Dari '.$request->unit_asal.' ke '.$request->unit_tujuan.($request->catatan ? ' - '.$request->catatan : ''),
                ]);

                foreach ($request->items as $item) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'master_obat_id' => $item['master_obat_id'],
                        'no_batch' => ! empty($item['no_batch']) ? trim($item['no_batch']) : '-',
                        'exp_date' => ! empty($item['exp_date']) ? $item['exp_date'] : null,
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => 0,
                    ]);
                }

                DB::commit();

                return redirect()->route('pemindahan.index')->with('success', 'Mutasi pemindahan obat internal OPD berhasil disimpan!');
            } catch (\Exception $e) {
                DB::rollBack();

                return redirect()->back()->withInput()->with('error', 'Gagal memproses pemindahan: '.$e->getMessage());
            }
        }

        // 2. Pemindahan Antar Gudang Pusat untuk Super Admin

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

        // Verifikasi ketersediaan stok fisik di gudang asal sebelum transaksi
        $groupedRequests = [];
        foreach ($request->items as $index => $item) {
            $obatId = $item['master_obat_id'];
            $batch = trim($item['no_batch'] ?? '');
            $qty = (int) ($item['jumlah'] ?? 0);

            $stok = StokObat::where('gudang_id', $request->gudang_asal_id)
                ->where('master_obat_id', $obatId)
                ->where('no_batch', $batch)
                ->first();

            $obat = MasterObat::find($obatId);
            $namaObat = $obat ? $obat->nama_obat : "ID {$obatId}";

            if (! $stok) {
                return redirect()->back()->withInput()->with('error', "Stok untuk '{$namaObat}' dengan Batch '{$batch}' tidak ditemukan di gudang asal.");
            }

            $key = $obatId.'__'.$batch;
            if (! isset($groupedRequests[$key])) {
                $groupedRequests[$key] = [
                    'nama_obat' => $namaObat,
                    'batch' => $batch,
                    'sisa_stok' => (int) $stok->jumlah,
                    'requested_total' => 0,
                    'exp_date' => $stok->exp_date,
                    'harga_satuan' => $stok->harga_satuan,
                ];
            }
            $groupedRequests[$key]['requested_total'] += $qty;
        }

        // Cek apakah permintaan pemindahan melebihi sisa stok fisik di gudang asal
        foreach ($groupedRequests as $group) {
            if ($group['requested_total'] > $group['sisa_stok']) {
                return redirect()->back()->withInput()->with('error', "Stok tidak mencukupi di gudang asal untuk '{$group['nama_obat']}' (Batch: {$group['batch']}). Stok fisik tersedia: {$group['sisa_stok']}, total dipindahkan: {$group['requested_total']}.");
            }
        }

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
                $obatId = $item['master_obat_id'];
                $batch = trim($item['no_batch']);
                $key = $obatId.'__'.$batch;
                $expDate = $groupedRequests[$key]['exp_date'] ?? null;
                $hargaSatuan = $groupedRequests[$key]['harga_satuan'] ?? null;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'master_obat_id' => $obatId,
                    'no_batch' => $batch,
                    'exp_date' => $expDate,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaSatuan,
                ]);
            }

            DB::commit();

            return redirect()->route('pemindahan.index')->with('success', 'Pemindahan barang berhasil disimpan! Stok gudang telah dimutasi secara otomatis oleh sistem.');
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

    public function destroyPemindahan(Transaksi $transaksi)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user && $user->isAdminOpd()) {
            if ($transaksi->instansi_id != $user->opd_id && $transaksi->user_id != $user->id) {
                abort(403, 'Anda tidak memiliki hak untuk menghapus transaksi pemindahan ini.');
            }
        } elseif ($user && ! $user->isSuperAdmin()) {
            abort(403, 'Penghapusan transaksi pemindahan hanya dapat dilakukan oleh Super Admin Gudang Pusat atau Admin OPD terkait.');
        }

        try {
            $transaksi->delete();

            return redirect()->route('pemindahan.index')->with('success', 'Data transaksi pemindahan berhasil dihapus.');
        } catch (\Exception $eb) {
            return redirect()->back()->with('error', 'Gagal menghapus transaksi: '.$eb->getMessage());
        }
    }
}
