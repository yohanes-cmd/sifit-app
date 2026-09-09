<?php

namespace App\Http\Controllers;

use App\Models\StokObat;
use Illuminate\Http\Request;

class StokObatController extends Controller
{
    public function index()
    {
        // Mengambil semua data stok beserta relasi nama obat dan nama gudangnya
        $stokObats = StokObat::with(['masterObat', 'gudang'])->latest()->get();
        
        return view('stok-obat.index', compact('stokObats'));
    }
}