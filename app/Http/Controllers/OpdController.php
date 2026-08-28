<?php

namespace App\Http\Controllers;

use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    // Menampilkan halaman tabel OPD
    public function index()
    {
        $opds = Opd::latest()->get();
        return view('opds.index', compact('opds'));
    }

    // Menyimpan data OPD baru
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Opd::create(['name' => $request->name]);
        
        return redirect()->route('opds.index')->with('success', 'OPD berhasil ditambahkan!');
    }

    // Menghapus data OPD
    public function destroy($id)
    {
        Opd::findOrFail($id)->delete();
        return redirect()->route('opds.index')->with('success', 'OPD berhasil dihapus!');
    }
}