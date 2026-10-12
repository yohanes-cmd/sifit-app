<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    public function index()
    {
        $pemasoks = Pemasok::latest()->get();

        return view('pemasok.index', compact('pemasoks'));
    }

    public function create()
    {
        return view('pemasok.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'pic' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Pemasok::create($request->all());

        return redirect()->route('pemasok.index')->with('success', 'Data pemasok berhasil ditambahkan!');
    }

    public function show(Pemasok $pemasok)
    {
        //
    }

    public function edit(Pemasok $pemasok)
    {
        return view('pemasok.edit', compact('pemasok'));
    }

    public function update(Request $request, Pemasok $pemasok)
    {
        $request->validate([
            'nama_pemasok' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'pic' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $pemasok->update($request->all());

        return redirect()->route('pemasok.index')->with('success', 'Data pemasok berhasil diperbarui!');
    }

    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();

        return redirect()->route('pemasok.index')->with('success', 'Data pemasok berhasil dihapus!');
    }

    public function showImportForm()
    {
        return view('pemasok.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);

        // TODO: Implement excel import logic
        return redirect()->route('pemasok.index')->with('success', 'Data pemasok berhasil diimport (placeholder).');
    }
}
