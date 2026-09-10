<?php

namespace App\Http\Controllers;

use App\Models\MasterObat;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Wajib dipanggil untuk fitur Slug

class MasterObatController extends Controller
{
    public function index()
    {
        $masterObats = MasterObat::latest()->get();
        return view('master-obat.index', compact('masterObats'));
    }

    public function create()
    {
        return view('master-obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|unique:master_obats,kode_obat',
            'nama_obat' => 'required|string|max:255',
            'kategori'  => 'required|in:Obat,Logistik',
            'satuan'    => 'required|string|max:50',
            'harga'     => 'required|numeric|min:0',
            'status'    => 'required|in:published,draft,inactive',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->all();

        // 1. Buat slug otomatis dari nama obat seperti kodingan lama
        $data['slug'] = Str::slug($request->nama_obat) . '-' . time();
        
        // 2. Cek checkbox resep dokter
        $data['requires_prescription'] = $request->has('requires_prescription') ? true : false;

        // 3. Logika upload gambar lokal
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/master_obat'), $filename);
            $data['gambar'] = 'uploads/master_obat/' . $filename;
        }

        MasterObat::create($data);

        return redirect()->route('master-obat.index')->with('success', 'Data Master Obat berhasil ditambahkan ke katalog!');
    }

    public function edit($id)
    {
        $masterObat = MasterObat::findOrFail($id);
        return view('master-obat.edit', compact('masterObat'));
    }

    public function update(Request $request, $id)
    {
        $masterObat = MasterObat::findOrFail($id);

        $request->validate([
            'kode_obat' => 'required|unique:master_obats,kode_obat,' . $id,
            'nama_obat' => 'required|string|max:255',
            'kategori'  => 'required|in:Obat,Logistik',
            'satuan'    => 'required|string|max:50',
            'harga'     => 'required|numeric|min:0',
            'status'    => 'required|in:published,draft,inactive',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->all();

        // Update slug otomatis jika nama diubah
        $data['slug'] = Str::slug($request->nama_obat) . '-' . time();
        
        // Cek checkbox resep dokter
        $data['requires_prescription'] = $request->has('requires_prescription') ? true : false;

        // Logika update gambar
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/master_obat'), $filename);
            $data['gambar'] = 'uploads/master_obat/' . $filename;
            
            if ($masterObat->gambar && file_exists(public_path($masterObat->gambar))) {
                unlink(public_path($masterObat->gambar));
            }
        }

        $masterObat->update($data);

        return redirect()->route('master-obat.index')->with('success', 'Data Master Obat berhasil diperbarui!');
    }

    // Nanti function frontendIndex & frontendShow milik Abang bisa ditaruh di sini!

    public function destroy($id)
    {
        $masterObat = MasterObat::findOrFail($id);
        
        if ($masterObat->gambar && file_exists(public_path($masterObat->gambar))) {
            unlink(public_path($masterObat->gambar));
        }

        $masterObat->delete();

        return redirect()->route('master-obat.index')->with('success', 'Data Master Obat berhasil dihapus!');
    }
}