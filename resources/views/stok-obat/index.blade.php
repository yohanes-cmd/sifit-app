@extends('layouts.app')

@section('title', 'Daftar Obat/Logistik - SIFIT')

@push('css')
<style>
    .table-stok th {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
        background-color: #f8fafc !important;
        color: #334155;
        vertical-align: middle;
    }
    .table-stok td {
        font-size: 13px;
        vertical-align: middle;
    }
    .badge-peringatan-safe {
        background-color: #ecfdf5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }
    .badge-peringatan-warn {
        background-color: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .badge-peringatan-danger {
        background-color: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .btn-export-tool {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    .btn-export-tool:hover {
        background-color: #115566;
        border-color: #115566;
        color: #ffffff;
    }
    .btn-sifit-add {
        background: linear-gradient(135deg, #115566 0%, #0d4452 50%, #4db6ac 100%);
        color: #ffffff !important;
        border: none;
        padding: 7px 18px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 6px rgba(17, 85, 102, 0.25);
    }
    .btn-sifit-add:hover {
        background: linear-gradient(135deg, #0d4452 0%, #09313b 50%, #3b9b91 100%);
        color: #ffffff !important;
    }
    .filter-gudang-select {
        display: inline-block;
        width: auto;
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 6px;
        border: 1.5px solid #cbd5e1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Header Page Title --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Daftar Obat/Logistik</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Daftar Obat/Logistik</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('stok-obat.create') }}" class="btn-sifit-add">
                            <i class="las la-plus-circle fs-16"></i> Tambah Obat/Logistik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    
                    {{-- Judul & Deskripsi --}}
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1" style="color: #115566;">Daftar Obat/Logistik</h5>
                        <p class="text-muted small mb-0">
                            Gunakan tabel dibawah untuk menampilkan dan menyaring hasil. Anda dapat men-download tabel tersebut sebagai csv, excel atau pdf.
                        </p>
                    </div>

                    {{-- Flash Alert Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="las la-check-circle me-1 fs-16 align-middle"></i>
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="las la-exclamation-circle me-1 fs-16 align-middle"></i>
                            <strong>Gagal!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Toolbar: Filter Gudang, Export Buttons & Search --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 pb-2 border-bottom">
                        
                        {{-- Filter Gudang & Export Tools --}}
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-primary btn-sm dropdown-toggle px-3 py-1 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" type="button" id="gudangDropdownTop" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #0284c7; border-color: #0284c7; border-radius: 6px;">
                                    <span>{{ $selectedGudangName }}</span>
                                </button>
                                <ul class="dropdown-menu shadow-sm border-0 py-1" aria-labelledby="gudangDropdownTop" style="border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item py-2 {{ !request('gudang_id') ? 'active fw-bold' : '' }}" href="{{ route('stok-obat.index', array_merge(request()->except('gudang_id'), ['gudang_id' => ''])) }}">
                                            Semua Gudang
                                        </a>
                                    </li>
                                    @foreach($gudangs as $g)
                                        <li>
                                            <a class="dropdown-item py-2 {{ request('gudang_id') == $g->id ? 'active fw-bold' : '' }}" href="{{ route('stok-obat.index', array_merge(request()->except('gudang_id'), ['gudang_id' => $g->id])) }}">
                                                {{ $g->nama_gudang }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="btn-group" role="group">
                                <a href="{{ route('stok-obat.export', ['gudang_id' => request('gudang_id')]) }}" class="btn btn-export-tool" title="Download Excel">
                                    <i class="las la-file-excel text-success me-1"></i> Excel
                                </a>
                                <a href="{{ route('stok-obat.export-csv', ['gudang_id' => request('gudang_id')]) }}" class="btn btn-export-tool" title="Download CSV">
                                    <i class="las la-file-csv text-primary me-1"></i> CSV
                                </a>
                                <button type="button" onclick="window.print()" class="btn btn-export-tool" title="Cetak / Print">
                                    <i class="las la-print text-secondary me-1"></i> Print
                                </button>
                            </div>
                        </div>

                        {{-- Search Input Form --}}
                        <div>
                            <form action="{{ route('stok-obat.index') }}" method="GET" class="d-inline-flex">
                                @if(request('gudang_id'))
                                    <input type="hidden" name="gudang_id" value="{{ request('gudang_id') }}">
                                @endif
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" placeholder="Cari obat, kode, batch..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit"><i class="las la-search"></i></button>
                                    @if(request('search'))
                                        <a href="{{ route('stok-obat.index', ['gudang_id' => request('gudang_id')]) }}" class="btn btn-outline-secondary" title="Reset"><i class="las la-times"></i></a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Form Bulk Delete Wrapper --}}
                    <form id="bulkDeleteForm" action="{{ route('stok-obat.bulk-destroy') }}" method="POST">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped table-stok mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 140px;">Kode Obat/Logistik</th>
                                        <th style="min-width: 170px;">Nama Obat/Logistik</th>
                                        <th style="min-width: 130px;">Sub Kategori</th>
                                        <th>Kategori</th>
                                        <th>Satuan Obat/Logistik</th>
                                        <th class="text-center">Peringatan Jumlah</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-center">Jumlah Barang</th>
                                        <th>Date Expired</th>
                                        <th>Ket.</th>
                                        <th class="text-end">Total Obat/Logistik</th>
                                        <th class="text-center">Total Jenis</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                        <th class="text-center" style="width: 40px;">
                                            <input type="checkbox" id="selectAllCheckbox" class="form-check-input" title="Pilih Semua">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($stokObats as $stok)
                                        @php
                                            $isExpired = $stok->exp_date && $stok->exp_date->isPast();
                                            $isNearExp = $stok->exp_date && !$isExpired && $stok->exp_date->diffInMonths(now()) <= 3;
                                            $isLowStock = $stok->jumlah <= ($stok->peringatan_jumlah ?? 10);
                                        @endphp
                                        <tr>
                                            {{-- 1. Kode Obat/Logistik --}}
                                            <td>
                                                <code class="text-dark fw-semibold">{{ $stok->display_kode }}</code>
                                                <div class="text-muted" style="font-size: 11px;">Batch: {{ $stok->no_batch }}</div>
                                            </td>

                                            {{-- 2. Nama Obat/Logistik --}}
                                            <td>
                                                <span class="fw-bold text-dark">{{ $stok->display_nama }}</span>
                                                @if($stok->gudang)
                                                    <div class="text-muted" style="font-size: 11px;">
                                                        <i class="las la-warehouse me-1"></i>{{ $stok->gudang->nama_gudang }}
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- 3. Sub Kategori --}}
                                            <td>
                                                <span class="text-muted">{{ $stok->sub_kategori ?: '-' }}</span>
                                            </td>

                                            {{-- 4. Kategori --}}
                                            <td>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                                    {{ $stok->display_kategori }}
                                                </span>
                                            </td>

                                            {{-- 5. Satuan --}}
                                            <td>{{ $stok->display_satuan }}</td>

                                            {{-- 6. Peringatan Jumlah --}}
                                            <td class="text-center">
                                                <span class="badge {{ $isLowStock ? 'badge-peringatan-danger' : 'badge-peringatan-safe' }}">
                                                    {{ $stok->peringatan_jumlah ?? 10 }}
                                                </span>
                                            </td>

                                            {{-- 7. Harga Satuan --}}
                                            <td class="text-end font-monospace">
                                                {{ number_format($stok->display_harga, 2, '.', ',') }}
                                            </td>

                                            {{-- 8. Jumlah Barang --}}
                                            <td class="text-center">
                                                <span class="fw-bold {{ $isLowStock ? 'text-danger' : 'text-success' }}" style="font-size: 14px;">
                                                    {{ $stok->jumlah }}
                                                </span>
                                            </td>

                                            {{-- 9. Date Expired --}}
                                            <td>
                                                @if($stok->exp_date)
                                                    @if($isExpired)
                                                        <span class="badge bg-danger" title="Sudah Kedaluwarsa">
                                                            {{ $stok->exp_date->format('Y-m-d') }} (Expired)
                                                        </span>
                                                    @elseif($isNearExp)
                                                        <span class="badge bg-warning text-dark" title="Mendekati Kedaluwarsa">
                                                            {{ $stok->exp_date->format('Y-m-d') }}
                                                        </span>
                                                    @else
                                                        <span class="text-dark">{{ $stok->exp_date->format('Y-m-d') }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            {{-- 10. Keterangan --}}
                                            <td>
                                                <span class="text-muted small">{{ $stok->keterangan ? Str::limit($stok->keterangan, 20) : '-' }}</span>
                                            </td>

                                            {{-- 11. Total Nilai (Harga * Jumlah) --}}
                                            <td class="text-end font-monospace fw-bold text-dark">
                                                {{ number_format($stok->total_nilai, 2, '.', ',') }}
                                            </td>

                                            {{-- 12. Total Jenis --}}
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border">
                                                    {{ $stok->master_obat_id ? 1 : 1 }}
                                                </span>
                                            </td>

                                            {{-- 13. Aksi (Detail, Edit, Hapus) --}}
                                            <td class="text-center">
                                                <div class="d-inline-flex gap-1 align-items-center">
                                                    {{-- Tombol Detail Modal --}}
                                                    <button type="button" class="btn btn-sm btn-outline-info p-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $stok->id }}" title="Detail Lengkap">
                                                        <i class="las la-eye fs-16"></i>
                                                    </button>

                                                    {{-- Tombol Edit (Kuning / Warning) --}}
                                                    <a href="{{ route('stok-obat.edit', $stok->id) }}" class="btn btn-sm btn-warning text-white p-1" title="Ubah Data">
                                                        <i class="las la-edit fs-16"></i>
                                                    </a>

                                                    {{-- Tombol Hapus (Merah / Danger) --}}
                                                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="confirmDeleteSingle({{ $stok->id }})" title="Hapus">
                                                        <i class="las la-trash-alt fs-16"></i>
                                                    </button>
                                                </div>
                                            </td>

                                            {{-- 14. Select Checkbox --}}
                                            <td class="text-center">
                                                <input type="checkbox" name="ids[]" value="{{ $stok->id }}" class="form-check-input row-checkbox">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="14" class="text-center py-4 text-muted">
                                                <i class="las la-box-open fs-36 d-block mb-2 text-secondary"></i>
                                                Belum ada data obat/logistik pada daftar stok ini.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </form>

                    {{-- Form Hapus Single Standalone --}}
                    <form id="singleDeleteForm" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>

                    {{-- Footer Bar: Tambah Button, Filter Bawah, Bulk Delete & Pagination --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mt-3 pt-3 border-top">
                        
                        {{-- Tombol Tambah & Dropdown Bawah --}}
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <a href="{{ route('stok-obat.create') }}" class="btn-sifit-add">
                                <i class="las la-plus-circle fs-16"></i> Tambah Obat/Logistik
                            </a>

                            <div class="dropdown d-inline-block">
                                <button class="btn btn-primary btn-sm dropdown-toggle px-3 py-1 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm" type="button" id="gudangDropdownBottom" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #0284c7; border-color: #0284c7; border-radius: 6px;">
                                    <span>{{ $selectedGudangName }}</span>
                                </button>
                                <ul class="dropdown-menu shadow-sm border-0 py-1" aria-labelledby="gudangDropdownBottom" style="border-radius: 8px; font-size: 13px;">
                                    <li>
                                        <a class="dropdown-item py-2 {{ !request('gudang_id') ? 'active fw-bold' : '' }}" href="{{ route('stok-obat.index', array_merge(request()->except('gudang_id'), ['gudang_id' => ''])) }}">
                                            Semua Gudang
                                        </a>
                                    </li>
                                    @foreach($gudangs as $g)
                                        <li>
                                            <a class="dropdown-item py-2 {{ request('gudang_id') == $g->id ? 'active fw-bold' : '' }}" href="{{ route('stok-obat.index', array_merge(request()->except('gudang_id'), ['gudang_id' => $g->id])) }}">
                                                {{ $g->nama_gudang }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Tombol Hapus Data Terpilih & Pagination --}}
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <button type="button" class="btn btn-danger btn-sm" id="btnBulkDelete" onclick="submitBulkDelete()" disabled>
                                <i class="las la-trash me-1"></i> Hapus Data Terpilih
                            </button>

                            <div>
                                {{ $stokObats->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Detail Modals --}}
@foreach($stokObats as $stok)
<div class="modal fade" id="detailModal{{ $stok->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $stok->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header text-white" style="background: #115566;">
                <h5 class="modal-title fs-15" id="detailModalLabel{{ $stok->id }}">
                    <i class="las la-info-circle me-1"></i> Detail Informasi Obat/Logistik: {{ $stok->display_nama }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    @if($stok->gambar)
                        <div class="col-md-4 text-center mb-3">
                            <img src="{{ asset($stok->gambar) }}" alt="{{ $stok->display_nama }}" class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                    @else
                        <div class="col-12">
                    @endif
                        <table class="table table-sm table-bordered">
                            <tbody>
                                <tr>
                                    <th class="bg-light" style="width: 35%;">Kode Obat/Logistik</th>
                                    <td><code>{{ $stok->display_kode }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Obat/Logistik</th>
                                    <td class="fw-bold">{{ $stok->display_nama }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Master Obat Referensi</th>
                                    <td>{{ $stok->masterObat->nama_obat ?? '-' }} ({{ $stok->masterObat->kode_obat ?? '-' }})</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori / Sub Kategori</th>
                                    <td>{{ $stok->display_kategori }} / {{ $stok->sub_kategori ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tahun Penerimaan</th>
                                    <td>{{ $stok->tahun_penerimaan ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nomor Batch</th>
                                    <td><strong>{{ $stok->no_batch }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Expired / Kode</th>
                                    <td>
                                        {{ $stok->exp_date ? $stok->exp_date->format('d-m-Y') : '-' }}
                                        @if($stok->date_expired_kode)
                                            <span class="text-muted">({{ $stok->date_expired_kode }})</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Satuan / Kemasan</th>
                                    <td>{{ $stok->display_satuan }} / {{ $stok->kemasan ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Harga Satuan / Jumlah Stok</th>
                                    <td>Rp {{ number_format($stok->display_harga, 2, ',', '.') }} | <strong>{{ $stok->jumlah }} {{ $stok->display_satuan }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Total Nilai</th>
                                    <td class="fw-bold text-success">Rp {{ number_format($stok->total_nilai, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Pabrikan</th>
                                    <td>{{ $stok->nama_pabrikan ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Faktur / Tgl Faktur</th>
                                    <td>{{ $stok->no_faktur ?: '-' }} / {{ $stok->tgl_faktur ? $stok->tgl_faktur->format('d-m-Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Kontrak / Tgl Kontrak</th>
                                    <td>{{ $stok->no_kontrak ?: '-' }} / {{ $stok->tgl_kontrak ? $stok->tgl_kontrak->format('d-m-Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Lokasi Gudang</th>
                                    <td>{{ $stok->gudang->nama_gudang ?? '-' }}</td>
                                </tr>
                                @if($stok->informasi_lengkap)
                                <tr>
                                    <th class="bg-light">Informasi Lengkap</th>
                                    <td>{!! nl2br(e($stok->informasi_lengkap)) !!}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const btnBulkDelete = document.getElementById('btnBulkDelete');

        function updateBulkButtonState() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            if (btnBulkDelete) {
                btnBulkDelete.disabled = checkedCount === 0;
                btnBulkDelete.innerHTML = `<i class="las la-trash me-1"></i> Hapus Data Terpilih (${checkedCount})`;
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkButtonState();
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                updateBulkButtonState();
                if (!this.checked && selectAll) {
                    selectAll.checked = false;
                }
            });
        });
    });

    function submitBulkDelete() {
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        if (checkedCount === 0) return;

        if (confirm(`Yakin ingin menghapus ${checkedCount} data obat/logistik terpilih secara permanen?`)) {
            document.getElementById('bulkDeleteForm').submit();
        }
    }

    function confirmDeleteSingle(id) {
        if (confirm('Yakin ingin menghapus data stok obat ini dari sistem?')) {
            const form = document.getElementById('singleDeleteForm');
            form.action = `/stok-obat/${id}`;
            form.submit();
        }
    }
</script>
@endpush