<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use App\Models\StatusKantor;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index()
    {
        $opds = Opd::latest()->get();

        return view('pengguna.opd.index', compact('opds'));
    }

    public function create()
    {
        $statusKantors = StatusKantor::orderBy('nama_status')->get();

        return view('pengguna.opd.create', compact('statusKantors'));
    }

    public function store(Request $request)
    {
        $validSlugs = StatusKantor::pluck('slug')->toArray();

        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'status_kantor' => 'required|in:'.implode(',', $validSlugs),
            'alamat' => 'nullable|string',
        ]);

        Opd::create($request->all());

        return redirect()->route('opd.index')->with('success', 'Data Instansi / OPD berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $opd = Opd::findOrFail($id);
        $statusKantors = StatusKantor::orderBy('nama_status')->get();

        return view('pengguna.opd.edit', compact('opd', 'statusKantors'));
    }

    public function update(Request $request, $id)
    {
        $validSlugs = StatusKantor::pluck('slug')->toArray();

        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'status_kantor' => 'required|in:'.implode(',', $validSlugs),
            'alamat' => 'nullable|string',
        ]);

        $opd = Opd::findOrFail($id);
        $opd->update($request->all());

        return redirect()->route('opd.index')->with('success', 'Data Instansi / OPD berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $opd = Opd::findOrFail($id);
        $opd->delete();

        return redirect()->route('opd.index')->with('success', 'Data Instansi / OPD berhasil dihapus!');
    }

    public function showImportForm()
    {
        return view('pengguna.opd.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);

        // TODO: Implement excel import logic
        return redirect()->route('opd.index')->with('success', 'Data Instansi berhasil diimport (placeholder).');
    }
}
