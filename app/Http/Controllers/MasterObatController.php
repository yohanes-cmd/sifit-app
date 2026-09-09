<?php

namespace App\Http\Controllers;

use App\Models\MasterObat;
use Illuminate\Http\Request;

class MasterObatController extends Controller
{
    public function index()
    {
        // Mengambil semua data master obat, diurutkan dari yang terbaru
        $masterObats = MasterObat::latest()->get();
        return view('master-obat.index', compact('masterObats'));
    }

    public function create()
    {
        // Menampilkan form tambah data
        return view('master-obat.create');
    }

    public function store(Request $request)
    {
        // Validasi inputan agar tidak ada kode yang kembar atau data kosong
        $request->validate([
            'kode_obat' => 'required|unique:master_obats,kode_obat',
            'nama_obat' => 'required|string|max:255',
            'kategori'  => 'required|in:Obat,Logistik',
            'satuan'    => 'required|string|max:50',
        ]);

        MasterObat::create($request->all());

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
            // Validasi kode obat unik, tapi abaikan jika kodenya milik data ini sendiri
            'kode_obat' => 'required|unique:master_obats,kode_obat,' . $id,
            'nama_obat' => 'required|string|max:255',
            'kategori'  => 'required|in:Obat,Logistik',
            'satuan'    => 'required|string|max:50',
        ]);

        $masterObat->update($request->all());

        return redirect()->route('master-obat.index')->with('success', 'Data Master Obat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $masterObat = MasterObat::findOrFail($id);
        $masterObat->delete();

        return redirect()->route('master-obat.index')->with('success', 'Data Master Obat berhasil dihapus!');
    }
}