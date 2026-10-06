<?php

namespace App\Http\Controllers;

use App\Models\StatusKantor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StatusKantorController extends Controller
{
    public function index()
    {
        $statusKantors = StatusKantor::orderBy('nama_status')->get();

        return view('pengaturan.status_kantor.index', compact('statusKantors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_status' => 'required|string|max:100|unique:status_kantors,nama_status',
        ], [
            'nama_status.unique' => 'Status dengan nama tersebut sudah ada.',
        ]);

        StatusKantor::create([
            'nama_status' => $request->nama_status,
            'slug' => Str::slug($request->nama_status, '_'),
        ]);

        return redirect()->route('status-kantor.index')->with('success', 'Status kepemilikan berhasil ditambahkan.');
    }

    public function update(Request $request, StatusKantor $statusKantor)
    {
        $request->validate([
            'nama_status' => 'required|string|max:100|unique:status_kantors,nama_status,'.$statusKantor->id,
        ], [
            'nama_status.unique' => 'Status dengan nama tersebut sudah ada.',
        ]);

        $statusKantor->update([
            'nama_status' => $request->nama_status,
            'slug' => Str::slug($request->nama_status, '_'),
        ]);

        return redirect()->route('status-kantor.index')->with('success', 'Status kepemilikan berhasil diperbarui.');
    }

    public function destroy(StatusKantor $statusKantor)
    {
        $statusKantor->delete();

        return redirect()->route('status-kantor.index')->with('success', 'Status kepemilikan berhasil dihapus.');
    }
}
