<?php

namespace App\Http\Controllers;

use App\Models\DetailPermohonan;
use App\Models\MasterObat;
use App\Models\Opd;
use App\Models\Permohonan;
use App\Models\StokObat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    /**
     * Tampilkan daftar permohonan barang/obat.
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = Permohonan::with(['opd', 'user', 'transaksi'])
            ->withCount('detailPermohonans')
            ->latest('tanggal_permohonan')
            ->latest('id');

        // Jika user adalah OPD, batasi hanya permohonan milik instansinya
        if ($user->isOpd()) {
            $userOpdId = $user->opd_id;
            if (! $userOpdId && $user->opd) {
                $opdObj = Opd::where('nama_opd', $user->opd)->first();
                $userOpdId = $opdObj?->id;
            }

            $query->where(function ($q) use ($user, $userOpdId) {
                if ($userOpdId) {
                    $q->where('opd_id', $userOpdId);
                } else {
                    $q->where('user_id', $user->id);
                }
            });
        } else {
            // Filter untuk Admin / Staf
            if ($request->filled('opd_id')) {
                $query->where('opd_id', $request->opd_id);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_permohonan', 'like', "%{$search}%")
                    ->orWhere('keperluan', 'like', "%{$search}%")
                    ->orWhereHas('opd', function ($oq) use ($search) {
                        $oq->where('nama_opd', 'like', "%{$search}%");
                    });
            });
        }

        $permohonans = $query->paginate(15)->withQueryString();
        $opds = Opd::orderBy('nama_opd')->get();

        // Hitung statistik ringkas untuk kartu atas
        $statQuery = Permohonan::query();
        if ($user->isOpd() && $user->opd_id) {
            $statQuery->where('opd_id', $user->opd_id);
        }
        $stats = [
            'total' => (clone $statQuery)->count(),
            'menunggu' => (clone $statQuery)->where('status', 'menunggu')->count(),
            'disetujui' => (clone $statQuery)->where('status', 'disetujui')->count(),
            'selesai' => (clone $statQuery)->where('status', 'selesai')->count(),
        ];

        return view('permohonan.index', compact('permohonans', 'opds', 'stats', 'user'));
    }

    /**
     * Tampilkan formulir pembuatan permohonan baru.
     */
    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        // Cari OPD pengguna jika OPD
        $userOpd = null;
        if ($user->isOpd()) {
            $userOpd = $user->opdInstansi;
            if (! $userOpd && $user->opd) {
                $userOpd = Opd::where('nama_opd', $user->opd)->first();
            }
        }

        $opds = Opd::orderBy('nama_opd')->get();

        // Ambil master obat yang aktif beserta total stok terkini
        $masterObats = MasterObat::where(function ($q) {
            $q->where('status', 'published')
                ->orWhere('status', 'active')
                ->orWhereNull('status');
        })
            ->withSum('stokObats as total_stok', 'jumlah')
            ->orderBy('nama_obat')
            ->get();

        return view('permohonan.create', compact('masterObats', 'opds', 'user', 'userOpd'));
    }

    /**
     * Simpan pengajuan permohonan obat baru.
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $rules = [
            'tanggal_permohonan' => 'required|date',
            'nomor_permohonan' => 'nullable|string|max:255',
            'keperluan' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'surat_pengantar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'items' => 'required|array|min:1',
            'items.*.master_obat_id' => 'required|exists:master_obats,id',
            'items.*.jumlah_diminta' => 'required|integer|min:1',
            'items.*.catatan' => 'nullable|string|max:255',
        ];

        if (! $user->isOpd()) {
            $rules['opd_id'] = 'required|exists:opds,id';
        }

        $request->validate($rules, [
            'items.required' => 'Minimal satu item obat harus ditambahkan ke permohonan.',
            'items.*.master_obat_id.required' => 'Pilih obat yang dimohonkan.',
            'items.*.jumlah_diminta.required' => 'Jumlah permintaan obat wajib diisi.',
            'items.*.jumlah_diminta.min' => 'Jumlah permintaan minimal 1.',
        ]);

        $opdId = $user->isOpd() ? ($user->opd_id ?? Opd::where('nama_opd', $user->opd)->value('id')) : $request->opd_id;

        if (! $opdId) {
            return redirect()->back()->withInput()->with('error', 'Instansi / OPD Anda belum terdaftar di sistem. Harap hubungi administrator.');
        }

        // Generate nomor permohonan otomatis jika tidak diisi manual
        $nomorPermohonan = $request->nomor_permohonan;
        if (empty($nomorPermohonan)) {
            $prefix = 'PRM/'.date('Ym').'/';
            $lastCount = Permohonan::where('nomor_permohonan', 'like', "{$prefix}%")->count() + 1;
            $nomorPermohonan = $prefix.str_pad($lastCount, 4, '0', STR_PAD_LEFT);
        }

        // Upload surat pengantar jika ada
        $suratPath = null;
        if ($request->hasFile('surat_pengantar')) {
            $suratPath = $request->file('surat_pengantar')->store('permohonan', 'public');
        }

        DB::beginTransaction();
        try {
            $permohonan = Permohonan::create([
                'nomor_permohonan' => $nomorPermohonan,
                'tanggal_permohonan' => $request->tanggal_permohonan,
                'opd_id' => $opdId,
                'user_id' => $user->id,
                'status' => 'menunggu',
                'keperluan' => $request->keperluan,
                'catatan' => $request->catatan,
                'surat_pengantar' => $suratPath,
            ]);

            foreach ($request->items as $item) {
                DetailPermohonan::create([
                    'permohonan_id' => $permohonan->id,
                    'master_obat_id' => $item['master_obat_id'],
                    'jumlah_diminta' => $item['jumlah_diminta'],
                    'jumlah_disetujui' => $item['jumlah_diminta'], // Default disetujui sama dengan diminta
                    'catatan' => $item['catatan'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('permohonan.show', $permohonan->id)->with('success', "Permohonan dengan nomor {$nomorPermohonan} berhasil diajukan!");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan permohonan: '.$e->getMessage());
        }
    }

    /**
     * Tampilkan detail permohonan obat.
     */
    public function show(Permohonan $permohonan)
    {
        /** @var User $user */
        $user = Auth::user();

        // Validasi akses OPD
        if ($user->isOpd() && $user->opd_id && $permohonan->opd_id !== $user->opd_id) {
            abort(403, 'Anda tidak memiliki hak akses melihat permohonan instansi lain.');
        }

        $permohonan->load([
            'opd',
            'user',
            'verifiedBy',
            'transaksi.gudangAsal',
            'detailPermohonans.masterObat.stokObats',
        ]);

        // Cek stok fisik yang tersedia di semua gudang untuk setiap item obat
        $stokTersedia = [];
        foreach ($permohonan->detailPermohonans as $detail) {
            $totalStokFisik = StokObat::where('master_obat_id', $detail->master_obat_id)
                ->where('jumlah', '>', 0)
                ->sum('jumlah');

            $stokTersedia[$detail->master_obat_id] = (int) $totalStokFisik;
        }

        return view('permohonan.show', compact('permohonan', 'stokTersedia', 'user'));
    }

    /**
     * Tampilan cetak resmi Formulir Permohonan Obat (Print-Ready A4).
     */
    public function print(Permohonan $permohonan)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isOpd() && $user->opd_id && $permohonan->opd_id !== $user->opd_id) {
            abort(403, 'Anda tidak memiliki hak akses mencetak permohonan instansi lain.');
        }

        $permohonan->load([
            'opd',
            'user',
            'verifiedBy',
            'transaksi',
            'detailPermohonans.masterObat',
        ]);

        return view('permohonan.print', compact('permohonan'));
    }

    /**
     * Verifikasi permohonan (Setujui / Tolak / Revisi Jumlah) oleh Admin/Petugas Farmasi.
     */
    public function verifikasi(Request $request, Permohonan $permohonan)
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->isSuperAdmin()) {
            abort(403, 'Verifikasi permohonan obat hanya dapat dilakukan oleh Super Admin Gudang Pusat.');
        }

        $request->validate([
            'status' => 'required|in:disetujui,ditolak,diproses',
            'catatan_verifikasi' => 'nullable|string',
            'disetujui' => 'nullable|array',
            'disetujui.*' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $permohonan->status = $request->status;
            $permohonan->catatan_verifikasi = $request->catatan_verifikasi;
            $permohonan->verified_by = $user->id;
            $permohonan->verified_at = now();
            $permohonan->save();

            // Update kuantitas disetujui jika ada penyesuaian dari admin
            if ($request->has('disetujui') && is_array($request->disetujui)) {
                foreach ($request->disetujui as $detailId => $qtyDisetujui) {
                    DetailPermohonan::where('id', $detailId)
                        ->where('permohonan_id', $permohonan->id)
                        ->update(['jumlah_disetujui' => (int) $qtyDisetujui]);
                }
            }

            DB::commit();

            $statusText = match ($request->status) {
                'disetujui' => 'disetujui dan siap dijadikan acuan pengeluaran barang.',
                'ditolak' => 'telah ditolak.',
                'diproses' => 'sedang diproses.',
                default => 'berhasil diperbarui.',
            };

            return redirect()->back()->with('success', "Permohonan berhasil {$statusText}");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal memverifikasi permohonan: '.$e->getMessage());
        }
    }

    /**
     * Batalkan atau hapus permohonan jika belum direalisasikan.
     */
    public function destroy(Permohonan $permohonan)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($permohonan->status === 'selesai' || $permohonan->transaksi()->exists()) {
            return redirect()->back()->with('error', 'Permohonan tidak dapat dihapus karena sudah direalisasikan ke Pengeluaran Barang (SBBK).');
        }

        if ($user->isAdminOpd()) {
            if ($permohonan->opd_id !== $user->opd_id) {
                abort(403, 'Anda tidak berhak menghapus permohonan instansi lain.');
            }
            if ($permohonan->status !== 'menunggu') {
                return redirect()->back()->with('error', 'Permohonan yang telah diverifikasi atau diproses tidak dapat dihapus oleh Admin OPD.');
            }
        }

        try {
            if ($permohonan->surat_pengantar && Storage::disk('public')->exists($permohonan->surat_pengantar)) {
                Storage::disk('public')->delete($permohonan->surat_pengantar);
            }

            $permohonan->delete();

            return redirect()->route('permohonan.index')->with('success', 'Data permohonan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus permohonan: '.$e->getMessage());
        }
    }
}
