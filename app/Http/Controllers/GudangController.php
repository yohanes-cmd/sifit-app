<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::latest()->get();
        return view('pengaturan.gudang.index', compact('gudangs'));
    }

    public function create()
    {
        return view('pengaturan.gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'tipe' => 'required|in:pusat,upt,vaksin,logistik', // Bisa disesuaikan dengan kebutuhan
        ]);

        Gudang::create($request->all());

        return redirect()->route('gudang.index')->with('success', 'Data Gudang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $gudang = Gudang::findOrFail($id);
        return view('pengaturan.gudang.edit', compact('gudang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'tipe' => 'required|in:pusat,upt,vaksin,logistik',
        ]);

        $gudang = Gudang::findOrFail($id);
        $gudang->update($request->all());

        return redirect()->route('gudang.index')->with('success', 'Data Gudang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();

        return redirect()->route('gudang.index')->with('success', 'Data Gudang berhasil dihapus!');
    }
}