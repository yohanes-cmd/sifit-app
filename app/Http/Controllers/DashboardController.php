<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Gudang;
use App\Models\MasterObat;
use App\Models\News;
use App\Models\Opd;
use App\Models\StokObat;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard overview.
     */
    public function index(): View
    {
        // 1. Metrik Utama
        $totalMasterObat = MasterObat::count();
        $totalStokObat = (int) StokObat::sum('jumlah');
        $totalPemasukan = Transaksi::whereIn('jenis_transaksi', ['masuk', 'pemasukan', 'Pemasukan'])->count();
        $totalPengeluaran = Transaksi::whereIn('jenis_transaksi', ['keluar', 'pengeluaran', 'Pengeluaran'])->count();
        $totalPemindahan = Transaksi::whereIn('jenis_transaksi', ['pindah', 'pemindahan', 'Pemindahan'])->count();
        $totalTransaksi = Transaksi::count();
        $totalGudang = Gudang::count();
        $totalOpd = Opd::count();
        $totalNews = News::count();
        $totalUser = User::count();
        $totalCategory = Category::count();

        // 2. Transaksi Terkini (5 transaksi terakhir)
        $recentTransactions = Transaksi::with(['gudangAsal', 'gudangTujuan', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Stok Obat Terkini
        $recentStocks = StokObat::with(['masterObat', 'gudang'])
            ->latest()
            ->take(5)
            ->get();

        // 4. Data Bulanan Transaksi (6 Bulan Terakhir) untuk ApexCharts
        $months = [];
        $masukMonthly = [];
        $keluarMonthly = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M Y');
            $months[] = $monthName;

            $masukCount = Transaksi::whereIn('jenis_transaksi', ['masuk', 'pemasukan', 'Pemasukan'])
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->count();

            $keluarCount = Transaksi::whereIn('jenis_transaksi', ['keluar', 'pengeluaran', 'Pengeluaran'])
                ->whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month)
                ->count();

            $masukMonthly[] = $masukCount;
            $keluarMonthly[] = $keluarCount;
        }

        return view('dashboard.index', compact(
            'totalMasterObat',
            'totalStokObat',
            'totalPemasukan',
            'totalPengeluaran',
            'totalPemindahan',
            'totalTransaksi',
            'totalGudang',
            'totalOpd',
            'totalNews',
            'totalUser',
            'totalCategory',
            'recentTransactions',
            'recentStocks',
            'months',
            'masukMonthly',
            'keluarMonthly'
        ));
    }
}
