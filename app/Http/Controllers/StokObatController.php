<?php

namespace App\Http\Controllers;

use App\Models\StokObat;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StokObatExport;

class StokObatController extends Controller
{
    public function index()
    {
        $stokObats = StokObat::with(['masterObat', 'gudang'])->latest()->get();
        return view('stok-obat.index', compact('stokObats'));
    }

    // Tambahkan fungsi hapus ini
    public function destroy($id)
    {
        $stok = StokObat::findOrFail($id);
        $stok->delete();

        return redirect()->back()->with('success', 'Data stok usang berhasil dihapus untuk pembersihan sistem.');
    }
    // Jangan lupa tambahkan: use Maatwebsite\Excel\Facades\Excel; dan use App\Exports\StokObatExport; di bagian atas file!
    
    public function exportExcel()
    {
        return Excel::download(new StokObatExport, 'Daftar_Stok_Logistik_' . date('Y-m-d') . '.xlsx');
    }

}