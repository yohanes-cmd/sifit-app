<?php

namespace App\Http\Controllers;

use App\Models\Opd;
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
        return view('pengguna.opd.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'status_kantor' => 'required|in:kantor_pusat,puskesmas,upt',
            'alamat' => 'nullable|string',
        ]);

        Opd::create($request->all());

        return redirect()->route('opd.index')->with('success', 'Data Instansi / OPD berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $opd = Opd::findOrFail($id);
        return view('pengguna.opd.edit', compact('opd'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_opd' => 'required|string|max:255',
            'status_kantor' => 'required|in:kantor_pusat,puskesmas,upt',
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
}