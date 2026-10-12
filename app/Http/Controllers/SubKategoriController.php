<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    public function index()
    {
        $subkategoris = SubKategori::latest()->get();

        return view('pengaturan.subkategori.index', compact('subkategoris'));
    }

    public function create()
    {
        return view('pengaturan.subkategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        SubKategori::create($request->all());

        return redirect()->route('subkategori.index')->with('success', 'Data sub kategori berhasil ditambahkan!');
    }

    public function show(SubKategori $subkategori)
    {
        return view('pengaturan.subkategori.show', compact('subkategori'));
    }

    public function edit(SubKategori $subkategori)
    {
        return view('pengaturan.subkategori.edit', compact('subkategori'));
    }

    public function update(Request $request, SubKategori $subkategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $subkategori->update($request->all());

        return redirect()->route('subkategori.index')->with('success', 'Data sub kategori berhasil diperbarui!');
    }

    public function destroy(SubKategori $subkategori)
    {
        $subkategori->delete();

        return redirect()->route('subkategori.index')->with('success', 'Data sub kategori berhasil dihapus!');
    }
}
