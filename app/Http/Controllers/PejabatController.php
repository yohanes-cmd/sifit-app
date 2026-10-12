<?php

namespace App\Http\Controllers;

use App\Models\Pejabat;
use Illuminate\Http\Request;

class PejabatController extends Controller
{
    public function index()
    {
        $pejabats = Pejabat::latest()->get();

        return view('pengaturan.pejabat.index', compact('pejabats'));
    }

    public function create()
    {
        return view('pengaturan.pejabat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'periode' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Pejabat::create($request->all());

        return redirect()->route('pejabat.index')->with('success', 'Data pejabat berhasil ditambahkan!');
    }

    public function show(Pejabat $pejabat)
    {
        return view('pengaturan.pejabat.show', compact('pejabat'));
    }

    public function edit(Pejabat $pejabat)
    {
        return view('pengaturan.pejabat.edit', compact('pejabat'));
    }

    public function update(Request $request, Pejabat $pejabat)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'periode' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $pejabat->update($request->all());

        return redirect()->route('pejabat.index')->with('success', 'Data pejabat berhasil diperbarui!');
    }

    public function destroy(Pejabat $pejabat)
    {
        $pejabat->delete();

        return redirect()->route('pejabat.index')->with('success', 'Data pejabat berhasil dihapus!');
    }
}
