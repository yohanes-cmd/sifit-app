<?php

namespace App\Http\Controllers;

use App\Exports\MasterObatExport;
use App\Models\MasterObat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MasterObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $query = MasterObat::latest();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_obat', 'like', "%{$search}%")
                    ->orWhere('nama_obat', 'like', "%{$search}%")
                    ->orWhere('kode_kemkes', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $masterObats = $query->paginate(15)->withQueryString();

        return view('master-obat.index', compact('masterObats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Generate automatic sequential kode obat (5 digits, e.g. 07197 or 00001)
        $latest = MasterObat::whereRaw('kode_obat REGEXP "^[0-9]+$"')->orderByRaw('CAST(kode_obat AS UNSIGNED) DESC')->first();
        if ($latest && is_numeric($latest->kode_obat)) {
            $nextCode = sprintf('%05d', (int) $latest->kode_obat + 1);
        } else {
            $maxId = (int) MasterObat::max('id');
            $nextCode = sprintf('%05d', $maxId + 1);
        }

        // Check user role permissions for Obat vs Logistik buttons
        $user = Auth::user();
        $isFarmasiOnly = false;
        $isLogistikOnly = false;

        if ($user) {
            $roles = $user->roles->pluck('name')->map(fn ($r) => strtolower($r))->toArray();
            $userOpd = strtolower($user->opd ?? '');

            if (in_array('farmasi', $roles) || str_contains($userOpd, 'farmasi')) {
                $isFarmasiOnly = true;
            } elseif (in_array('logistik', $roles) || str_contains($userOpd, 'logistik')) {
                $isLogistikOnly = true;
            }
        }

        return view('master-obat.create', compact('nextCode', 'isFarmasiOnly', 'isLogistikOnly'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_obat' => 'required|string|max:100|unique:master_obats,kode_obat',
            'nama_obat' => 'required|string|max:255',
            'kode_kemkes' => 'nullable|string|max:100',
            'kategori' => 'required|in:Obat,Logistik',
            'satuan' => 'nullable|string|max:50',
            'harga' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:published,draft,inactive',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ], [
            'kode_obat.required' => 'Kode Obat/Logistik wajib diisi.',
            'kode_obat.unique' => 'Kode Obat/Logistik ini sudah digunakan oleh data lain.',
            'nama_obat.required' => 'Nama Obat/Logistik wajib diisi.',
            'kategori.required' => 'Pilih jenis kategori (Obat atau Logistik).',
        ]);

        $validated['slug'] = Str::slug($validated['nama_obat']).'-'.time();
        $validated['satuan'] = $validated['satuan'] ?? 'Pcs';
        $validated['harga'] = $validated['harga'] ?? 0;
        $validated['status'] = $validated['status'] ?? 'published';
        $validated['requires_prescription'] = $request->has('requires_prescription');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/master_obat'), $filename);
            $validated['gambar'] = 'uploads/master_obat/'.$filename;
        }

        MasterObat::create($validated);

        return redirect()->route('master-obat.index')->with('success', 'Master Obat/Logistik berhasil ditambahkan ke katalog!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $masterObat = MasterObat::findOrFail($id);

        $user = Auth::user();
        $isFarmasiOnly = false;
        $isLogistikOnly = false;

        if ($user) {
            $roles = $user->roles->pluck('name')->map(fn ($r) => strtolower($r))->toArray();
            $userOpd = strtolower($user->opd ?? '');

            if (in_array('farmasi', $roles) || str_contains($userOpd, 'farmasi')) {
                $isFarmasiOnly = true;
            } elseif (in_array('logistik', $roles) || str_contains($userOpd, 'logistik')) {
                $isLogistikOnly = true;
            }
        }

        return view('master-obat.edit', compact('masterObat', 'isFarmasiOnly', 'isLogistikOnly'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $masterObat = MasterObat::findOrFail($id);

        $validated = $request->validate([
            'kode_obat' => 'required|string|max:100|unique:master_obats,kode_obat,'.$id,
            'nama_obat' => 'required|string|max:255',
            'kode_kemkes' => 'nullable|string|max:100',
            'kategori' => 'required|in:Obat,Logistik',
            'satuan' => 'nullable|string|max:50',
            'harga' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:published,draft,inactive',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ], [
            'kode_obat.required' => 'Kode Obat/Logistik wajib diisi.',
            'kode_obat.unique' => 'Kode Obat/Logistik ini sudah digunakan oleh data lain.',
            'nama_obat.required' => 'Nama Obat/Logistik wajib diisi.',
            'kategori.required' => 'Pilih jenis kategori (Obat atau Logistik).',
        ]);

        $validated['slug'] = Str::slug($validated['nama_obat']).'-'.time();
        $validated['satuan'] = $validated['satuan'] ?? $masterObat->satuan ?? 'Pcs';
        $validated['harga'] = $validated['harga'] ?? $masterObat->harga ?? 0;
        $validated['status'] = $validated['status'] ?? $masterObat->status ?? 'published';
        $validated['requires_prescription'] = $request->has('requires_prescription');

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/master_obat'), $filename);
            $validated['gambar'] = 'uploads/master_obat/'.$filename;

            if ($masterObat->gambar && file_exists(public_path($masterObat->gambar))) {
                @unlink(public_path($masterObat->gambar));
            }
        }

        $masterObat->update($validated);

        return redirect()->route('master-obat.index')->with('success', 'Data Master Obat/Logistik berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $masterObat = MasterObat::findOrFail($id);

        if ($masterObat->gambar && file_exists(public_path($masterObat->gambar))) {
            @unlink(public_path($masterObat->gambar));
        }

        $masterObat->delete();

        return redirect()->route('master-obat.index')->with('success', 'Data Master Obat/Logistik berhasil dihapus.');
    }

    /**
     * Export to Excel.
     */
    public function exportExcel(Request $request): BinaryFileResponse
    {
        $search = $request->get('search');

        return Excel::download(new MasterObatExport($search), 'Master_Obat_Logistik_'.date('Y-m-d').'.xlsx');
    }

    /**
     * Export to CSV.
     */
    public function exportCsv(Request $request): BinaryFileResponse
    {
        $search = $request->get('search');

        return Excel::download(new MasterObatExport($search), 'Master_Obat_Logistik_'.date('Y-m-d').'.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Print View
     */
    public function print(Request $request): View
    {
        $search = $request->get('search');
        $query = MasterObat::latest();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_obat', 'like', "%{$search}%")
                    ->orWhere('nama_obat', 'like', "%{$search}%")
                    ->orWhere('kode_kemkes', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $masterObats = $query->get(); // Get all without pagination

        return view('master-obat.print', compact('masterObats'));
    }
}
