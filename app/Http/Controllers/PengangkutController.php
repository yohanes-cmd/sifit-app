<?php

namespace App\Http\Controllers;

use App\Models\Pengangkut;
use Illuminate\Http\Request;

class PengangkutController extends Controller
{
    public function index()
    {
        $pengangkuts = Pengangkut::latest()->get();

        return view('pengaturan.pengangkut.index', compact('pengangkuts'));
    }

    public function create()
    {
        return view('pengaturan.pengangkut.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'jenis_kendaraan' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Pengangkut::create($request->all());

        return redirect()->route('pengangkut.index')->with('success', 'Data pengangkut berhasil ditambahkan!');
    }

    public function show(Pengangkut $pengangkut)
    {
        return view('pengaturan.pengangkut.show', compact('pengangkut'));
    }

    public function edit(Pengangkut $pengangkut)
    {
        return view('pengaturan.pengangkut.edit', compact('pengangkut'));
    }

    public function update(Request $request, Pengangkut $pengangkut)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'jenis_kendaraan' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $pengangkut->update($request->all());

        return redirect()->route('pengangkut.index')->with('success', 'Data pengangkut berhasil diperbarui!');
    }

    public function destroy(Pengangkut $pengangkut)
    {
        $pengangkut->delete();

        return redirect()->route('pengangkut.index')->with('success', 'Data pengangkut berhasil dihapus!');
    }
}
