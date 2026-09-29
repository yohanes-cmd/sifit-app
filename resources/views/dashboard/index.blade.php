@extends('layouts.app')

@section('title', 'Dashboard Administrator - SiFit')

@push('css')
<style>
    .stat-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        overflow: hidden;
        position: relative;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(17, 85, 102, 0.12) !important;
    }
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .bg-sifit-primary {
        background: linear-gradient(135deg, #115566 0%, #0d4452 100%) !important;
        color: #ffffff !important;
    }
    .bg-sifit-accent {
        background: linear-gradient(135deg, #4db6ac 0%, #2e8b82 100%) !important;
        color: #ffffff !important;
    }
    .bg-sifit-soft-primary {
        background-color: rgba(17, 85, 102, 0.1) !important;
        color: #115566 !important;
    }
    .bg-sifit-soft-accent {
        background-color: rgba(77, 182, 172, 0.15) !important;
        color: #0b3a46 !important;
    }
    .quick-action-btn {
        transition: all 0.2s ease;
        border-radius: 10px;
        font-weight: 500;
    }
    .quick-action-btn:hover {
        transform: translateY(-2px);
    }
    .table-dashboard th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<!-- Header Salam & Quick Actions -->
<div class="row align-items-center mb-4">
    <div class="col-md-7">
        <div class="page-title-box pb-0">
            <h4 class="page-title mb-1 fw-bold text-dark" style="font-size: 22px;">
                Selamat Datang, {{ auth()->user()->name }}! 👋
            </h4>
            <p class="text-muted mb-0">
                Pusat kendali operasional logistik obat, inventaris gudang, dan berita sistem SiFit.
            </p>
        </div>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <div class="d-inline-flex flex-wrap gap-2">
            <a href="{{ route('pemasukan.create') }}" class="btn btn-primary quick-action-btn shadow-sm">
                <i class="las la-truck-loading me-1 fs-16 align-text-bottom"></i> Pemasukan
            </a>
            <a href="{{ route('pengeluaran.create') }}" class="btn btn-info quick-action-btn shadow-sm text-white">
                <i class="las la-dolly me-1 fs-16 align-text-bottom"></i> Pengeluaran
            </a>
            <a href="{{ route('master-obat.index') }}" class="btn btn-outline-primary quick-action-btn">
                <i class="las la-pills me-1 fs-16 align-text-bottom"></i> Master Obat
            </a>
        </div>
    </div>
</div>

<!-- 4 Kartu Statistik Utama -->
<div class="row">
    <!-- Card 1: Master Obat & Stok -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold fs-13 text-uppercase ls-1">Master & Stok Obat</span>
                    <div class="stat-icon bg-sifit-soft-primary">
                        <i class="las la-pills text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline justify-content-between">
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalMasterObat) }}</h3>
                        <small class="text-muted">Jenis Master Obat</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-sifit-soft-primary px-2 py-1 fs-12 fw-bold">
                            <i class="las la-boxes me-1"></i>{{ number_format($totalStokObat) }} Total Fisik
                        </span>
                    </div>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Card 2: Transaksi Logistik -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold fs-13 text-uppercase ls-1">Aktivitas Transaksi</span>
                    <div class="stat-icon bg-sifit-soft-accent">
                        <i class="las la-exchange-alt" style="color: #115566;"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline justify-content-between">
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalTransaksi) }}</h3>
                        <small class="text-muted">Total Transaksi</small>
                    </div>
                    <div class="text-end">
                        <small class="text-success fw-semibold d-block"><i class="las la-arrow-down"></i> Masuk: {{ $totalPemasukan }}</small>
                        <small class="text-danger fw-semibold d-block"><i class="las la-arrow-up"></i> Keluar: {{ $totalPengeluaran }}</small>
                    </div>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Card 3: Gudang & Instansi OPD -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold fs-13 text-uppercase ls-1">Gudang & OPD</span>
                    <div class="stat-icon bg-sifit-soft-primary">
                        <i class="las la-hospital text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline justify-content-between">
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalOpd) }}</h3>
                        <small class="text-muted">Instansi / OPD Mitra</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 fs-12">
                            <i class="las la-warehouse me-1"></i>{{ $totalGudang }} Gudang
                        </span>
                    </div>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Card 4: Berita & Pengguna -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="text-muted fw-semibold fs-13 text-uppercase ls-1">Informasi & Pengguna</span>
                    <div class="stat-icon bg-sifit-soft-accent">
                        <i class="las la-users text-info"></i>
                    </div>
                </div>
                <div class="d-flex align-items-baseline justify-content-between">
                    <div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalUser) }}</h3>
                        <small class="text-muted">Pengguna Terdaftar</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-sifit-soft-accent text-dark px-2 py-1 fs-12 fw-bold">
                            <i class="las la-newspaper me-1"></i>{{ $totalNews }} Berita
                        </span>
                    </div>
                </div>
            </div>
            <div class="progress" style="height: 4px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Section Grafik Analitik & Ringkasan -->
<div class="row">
    <!-- Grafik Tren Transaksi Masuk vs Keluar (ApexCharts) -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header border-0 bg-transparent pt-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title fw-bold mb-1">Tren Aktivitas Logistik Obat</h5>
                    <p class="text-muted small mb-0">Statistik transaksi pemasukan dan pengeluaran 6 bulan terakhir</p>
                </div>
                <span class="badge bg-sifit-soft-primary px-3 py-2 fw-semibold">
                    <i class="las la-chart-area me-1"></i> Real-time Log
                </span>
            </div>
            <div class="card-body">
                <div id="chartTransaksiTrend" style="min-height: 330px;"></div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Cepat & Status Distribusi -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header border-0 bg-transparent pt-4 pb-0">
                <h5 class="card-title fw-bold mb-1">Distribusi Transaksi</h5>
                <p class="text-muted small mb-0">Proporsi jenis transaksi barang dalam sistem</p>
            </div>
            <div class="card-body d-flex flex-column justify-content-center">
                <div id="chartTransaksiDonut" style="min-height: 250px;"></div>
                
                <div class="mt-3 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted"><i class="las la-square fs-14 me-1" style="color: #115566;"></i> Pemasukan</span>
                        <span class="fw-bold fs-13">{{ $totalPemasukan }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small text-muted"><i class="las la-square fs-14 me-1" style="color: #4db6ac;"></i> Pengeluaran</span>
                        <span class="fw-bold fs-13">{{ $totalPengeluaran }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="las la-square fs-14 me-1" style="color: #ffb822;"></i> Pemindahan</span>
                        <span class="fw-bold fs-13">{{ $totalPemindahan }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Tabel Data Terbaru -->
<div class="row">
    <!-- 5 Transaksi Logistik Terakhir -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header border-0 bg-transparent pt-4 pb-2 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title fw-bold mb-1">Transaksi Barang Terbaru</h5>
                    <p class="text-muted small mb-0">5 riwayat transaksi logistik terakhir yang tercatat</p>
                </div>
                <a href="{{ route('stok-obat.index') }}" class="btn btn-sm btn-outline-primary">
                    Lihat Semua <i class="las la-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dashboard table-hover align-middle mb-0">
                        <thead class="bg-light-subtle text-muted">
                            <tr>
                                <th class="ps-4">No. Surat</th>
                                <th>Jenis</th>
                                <th>Gudang / Lokasi</th>
                                <th>Tanggal</th>
                                <th class="pe-4">Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $transaksi)
                            <tr>
                                <td class="ps-4 fw-semibold text-dark">
                                    {{ $transaksi->nomor_surat ?: '-' }}
                                </td>
                                <td>
                                    @php
                                        $jenis = strtolower($transaksi->jenis_transaksi);
                                    @endphp
                                    @if(in_array($jenis, ['masuk', 'pemasukan']))
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="las la-arrow-down me-1"></i> Pemasukan
                                        </span>
                                    @elseif(in_array($jenis, ['keluar', 'pengeluaran']))
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                            <i class="las la-arrow-up me-1"></i> Pengeluaran
                                        </span>
                                    @else
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">
                                            <i class="las la-exchange-alt me-1"></i> Pemindahan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted d-block">
                                        @if($transaksi->gudangAsal)
                                            <i class="las la-warehouse"></i> {{ $transaksi->gudangAsal->nama_gudang ?? $transaksi->gudangAsal->nama }}
                                        @elseif($transaksi->gudangTujuan)
                                            <i class="las la-warehouse"></i> {{ $transaksi->gudangTujuan->nama_gudang ?? $transaksi->gudangTujuan->nama }}
                                        @else
                                            -
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <small class="fw-medium text-dark">
                                        {{ $transaksi->tanggal ? \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y') : $transaksi->created_at->format('d M Y') }}
                                    </small>
                                </td>
                                <td class="pe-4">
                                    <small class="text-muted">{{ $transaksi->user->name ?? 'Admin' }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="las la-inbox fs-32 d-block mb-1 text-secondary"></i>
                                    Belum ada transaksi logistik yang tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Obat Terkini -->
    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header border-0 bg-transparent pt-4 pb-2 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title fw-bold mb-1">Stok Obat Terkini</h5>
                    <p class="text-muted small mb-0">Daftar stok obat yang tersimpan di gudang</p>
                </div>
                <a href="{{ route('stok-obat.index') }}" class="btn btn-sm btn-outline-primary">
                    Detail <i class="las la-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dashboard table-hover align-middle mb-0">
                        <thead class="bg-light-subtle text-muted">
                            <tr>
                                <th class="ps-4">Nama Obat</th>
                                <th>Batch / Exp</th>
                                <th class="text-end pe-4">Kuantitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStocks as $stok)
                            <tr>
                                <td class="ps-4">
                                    <h6 class="mb-0 fw-semibold text-dark fs-13">{{ $stok->masterObat->nama_obat ?? 'Obat #'.$stok->master_obat_id }}</h6>
                                    <small class="text-muted">{{ $stok->gudang->nama_gudang ?? ($stok->gudang->nama ?? 'Gudang Utama') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary fs-11">
                                        Batch: {{ $stok->no_batch ?: '-' }}
                                    </span>
                                    @if($stok->exp_date || $stok->expired_date)
                                        <small class="d-block text-muted mt-1 fs-11">
                                            Exp: {{ \Carbon\Carbon::parse($stok->exp_date ?: $stok->expired_date)->format('d/m/Y') }}
                                        </small>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-primary px-3 py-1 fs-12 fw-bold">
                                        {{ number_format($stok->jumlah) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    <i class="las la-boxes fs-32 d-block mb-1 text-secondary"></i>
                                    Belum ada data stok obat di gudang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data dari Controller
        const months = @json($months);
        const masukData = @json($masukMonthly);
        const keluarData = @json($keluarMonthly);
        const totalPemasukan = {{ $totalPemasukan }};
        const totalPengeluaran = {{ $totalPengeluaran }};
        const totalPemindahan = {{ $totalPemindahan }};

        // 1. ApexChart Tren Transaksi Masuk vs Keluar
        const trendOptions = {
            chart: {
                height: 320,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'inherit'
            },
            colors: ['#115566', '#4db6ac'],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: [3, 3]
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            series: [
                {
                    name: 'Pemasukan Barang',
                    data: masukData
                },
                {
                    name: 'Pengeluaran Barang',
                    data: keluarData
                }
            ],
            xaxis: {
                categories: months,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#8c98a4', fontSize: '12px' }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: '#8c98a4', fontSize: '12px' }
                }
            },
            grid: {
                borderColor: '#eef2f7',
                strokeDashArray: 4
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                markers: { radius: 12 }
            }
        };

        const chartTrend = new ApexCharts(document.querySelector("#chartTransaksiTrend"), trendOptions);
        chartTrend.render();

        // 2. ApexChart Donut Distribusi Transaksi
        const donutSeries = (totalPemasukan === 0 && totalPengeluaran === 0 && totalPemindahan === 0) 
                            ? [1, 1, 1] 
                            : [totalPemasukan, totalPengeluaran, totalPemindahan];

        const donutOptions = {
            chart: {
                height: 240,
                type: 'donut',
                fontFamily: 'inherit'
            },
            colors: ['#115566', '#4db6ac', '#ffb822'],
            labels: ['Pemasukan', 'Pengeluaran', 'Pemindahan'],
            series: donutSeries,
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                color: '#8c98a4',
                                formatter: function (w) {
                                    return {{ $totalTransaksi }};
                                }
                            }
                        }
                    }
                }
            },
            legend: { show: false },
            stroke: { width: 0 }
        };

        const chartDonut = new ApexCharts(document.querySelector("#chartTransaksiDonut"), donutOptions);
        chartDonut.render();
    });
</script>
@endpush