<?php

namespace App\Http\Controllers;

use App\Exports\StokObatExport;
use App\Models\Gudang;
use App\Models\MasterObat;
use App\Models\StokObat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StokObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $gudangId = $request->get('gudang_id');
        $search = $request->get('search');

        $query = StokObat::with(['masterObat', 'gudang'])->latest();

        if (! empty($gudangId) && $gudangId !== 'all') {
            $query->where('gudang_id', $gudangId);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_obat_logistik', 'like', "%{$search}%")
                    ->orWhere('nama_obat_logistik', 'like', "%{$search}%")
                    ->orWhere('no_batch', 'like', "%{$search}%")
                    ->orWhere('sub_kategori', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhereHas('masterObat', function ($mq) use ($search) {
                        $mq->where('nama_obat', 'like', "%{$search}%")
                            ->orWhere('kode_obat', 'like', "%{$search}%");
                    });
            });
        }

        $stokObats = $query->paginate(15)->withQueryString();
        $gudangs = Gudang::orderBy('nama_gudang')->get();

        // Count total variasi jenis per master_obat
        $totalJenisCount = StokObat::distinct('master_obat_id')->count('master_obat_id');

        $selectedGudangName = 'Semua Gudang';
        if (! empty($gudangId) && $gudangId !== 'all') {
            $selectedGudang = $gudangs->firstWhere('id', (int) $gudangId);
            if ($selectedGudang) {
                $selectedGudangName = $selectedGudang->nama_gudang;
            }
        }

        return view('stok-obat.index', compact('stokObats', 'gudangs', 'gudangId', 'selectedGudangName', 'totalJenisCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $masterObats = MasterObat::where('status', '!=', 'inactive')->orderBy('nama_obat')->get();
        $gudangs = Gudang::orderBy('nama_gudang')->get();

        return view('stok-obat.create', compact('masterObats', 'gudangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'master_obat_id' => 'required|exists:master_obats,id',
            'gudang_id' => 'required|exists:gudangs,id',
            'kode_obat_logistik' => 'nullable|string|max:255',
            'nama_obat_logistik' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'sub_kategori' => 'nullable|string|max:150',
            'tahun_penerimaan' => 'nullable|string|max:10',
            'exp_date' => 'nullable|date',
            'date_expired_kode' => 'nullable|string|max:100',
            'no_batch' => 'required|string|max:100',
            'satuan' => 'nullable|string|max:50',
            'kemasan' => 'nullable|string|max:100',
            'harga_satuan' => 'nullable|numeric|min:0',
            'jumlah' => 'required|integer|min:0',
            'nama_pabrikan' => 'nullable|string|max:255',
            'no_faktur' => 'nullable|string|max:100',
            'tgl_faktur' => 'nullable|date',
            'no_kontrak' => 'nullable|string|max:100',
            'tgl_kontrak' => 'nullable|date',
            'peringatan_jumlah' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'informasi_lengkap' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ], [
            'master_obat_id.required' => 'Master Obat/Logistik wajib dipilih.',
            'gudang_id.required' => 'Lokasi Gudang penyimpanan wajib dipilih.',
            'no_batch.required' => 'Nomor Batch wajib diisi.',
            'jumlah.required' => 'Jumlah barang wajib diisi minimal 0.',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/stok_obat'), $filename);
            $validated['gambar'] = 'uploads/stok_obat/'.$filename;
        }

        // Set default values if empty from MasterObat
        $master = MasterObat::find($validated['master_obat_id']);
        if ($master) {
            if (empty($validated['kode_obat_logistik'])) {
                $validated['kode_obat_logistik'] = $master->kode_obat;
            }
            if (empty($validated['nama_obat_logistik'])) {
                $validated['nama_obat_logistik'] = $master->nama_obat;
            }
            if (empty($validated['satuan'])) {
                $validated['satuan'] = $master->satuan;
            }
            if (empty($validated['harga_satuan'])) {
                $validated['harga_satuan'] = $master->harga;
            }
            if (empty($validated['kategori'])) {
                $validated['kategori'] = $master->kategori;
            }
        }

        $validated['peringatan_jumlah'] = $request->input('peringatan_jumlah', 10);

        StokObat::create($validated);

        return redirect()->route('stok-obat.index')->with('success', 'Data Obat/Logistik berhasil ditambahkan ke daftar stok!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $stokObat = StokObat::findOrFail($id);
        $masterObats = MasterObat::where('status', '!=', 'inactive')->orderBy('nama_obat')->get();
        $gudangs = Gudang::orderBy('nama_gudang')->get();

        return view('stok-obat.edit', compact('stokObat', 'masterObats', 'gudangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $stokObat = StokObat::findOrFail($id);

        $validated = $request->validate([
            'master_obat_id' => 'required|exists:master_obats,id',
            'gudang_id' => 'required|exists:gudangs,id',
            'kode_obat_logistik' => 'nullable|string|max:255',
            'nama_obat_logistik' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'sub_kategori' => 'nullable|string|max:150',
            'tahun_penerimaan' => 'nullable|string|max:10',
            'exp_date' => 'nullable|date',
            'date_expired_kode' => 'nullable|string|max:100',
            'no_batch' => 'required|string|max:100',
            'satuan' => 'nullable|string|max:50',
            'kemasan' => 'nullable|string|max:100',
            'harga_satuan' => 'nullable|numeric|min:0',
            'jumlah' => 'required|integer|min:0',
            'nama_pabrikan' => 'nullable|string|max:255',
            'no_faktur' => 'nullable|string|max:100',
            'tgl_faktur' => 'nullable|date',
            'no_kontrak' => 'nullable|string|max:100',
            'tgl_kontrak' => 'nullable|date',
            'peringatan_jumlah' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'informasi_lengkap' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/stok_obat'), $filename);
            $validated['gambar'] = 'uploads/stok_obat/'.$filename;

            if ($stokObat->gambar && file_exists(public_path($stokObat->gambar))) {
                @unlink(public_path($stokObat->gambar));
            }
        }

        $stokObat->update($validated);

        return redirect()->route('stok-obat.index')->with('success', 'Data Stok Obat/Logistik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $stok = StokObat::findOrFail($id);

        if ($stok->gambar && file_exists(public_path($stok->gambar))) {
            @unlink(public_path($stok->gambar));
        }

        $stok->delete();

        return redirect()->back()->with('success', 'Data stok obat berhasil dihapus dari sistem.');
    }

    /**
     * Remove multiple resources from storage (Bulk Delete).
     */
    public function bulkDestroy(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:stok_obats,id',
        ], [
            'ids.required' => 'Pilih minimal satu data obat/logistik yang ingin dihapus.',
        ]);

        $stoks = StokObat::whereIn('id', $request->ids)->get();

        foreach ($stoks as $stok) {
            if ($stok->gambar && file_exists(public_path($stok->gambar))) {
                @unlink(public_path($stok->gambar));
            }
            $stok->delete();
        }

        return redirect()->back()->with('success', count($request->ids).' data stok obat terpilih berhasil dihapus.');
    }

    /**
     * Export to Excel.
     */
    public function exportExcel(Request $request): BinaryFileResponse
    {
        $gudangId = $request->get('gudang_id');

        return Excel::download(new StokObatExport($gudangId ? (int) $gudangId : null), 'Daftar_Stok_Logistik_'.date('Y-m-d').'.xlsx');
    }

    /**
     * Export to CSV.
     */
    public function exportCsv(Request $request): BinaryFileResponse
    {
        $gudangId = $request->get('gudang_id');

        return Excel::download(new StokObatExport($gudangId ? (int) $gudangId : null), 'Daftar_Stok_Logistik_'.date('Y-m-d').'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
