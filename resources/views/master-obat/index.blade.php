@extends('layouts.app')

@section('title', 'Master Obat/Logistik - SIFIT')

@push('css')
<style>
    .table-master th {
        font-size: 12.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        background-color: #f8fafc !important;
        color: #334155;
        vertical-align: middle;
    }
    .table-master td {
        font-size: 13.5px;
        vertical-align: middle;
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
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 13.5px;
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
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Master Obat/Logistik</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Master Obat/Logistik</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('master-obat.create') }}" class="btn-sifit-add">
                            <i class="las la-plus-circle fs-16"></i> Tambah Obat/Logistik
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    
                    {{-- Judul & Deskripsi --}}
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1" style="color: #115566;">Master Obat/Logistik</h5>
                        <p class="text-muted small mb-0">
                            Gunakan tabel dibawah untuk menampilkan dan menyaring hasil. Anda dapat men-download tabel tersebut sebagai csv, excel atau pdf.
                        </p>
                    </div>

                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="las la-check-circle me-1 fs-16 align-middle"></i>
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Toolbar: Export & Search --}}
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 pb-2 border-bottom">
                        
                        {{-- Export Buttons --}}
                        <div class="btn-group" role="group">
                            <a href="{{ route('master-obat.export', ['search' => request('search')]) }}" class="btn btn-export-tool" title="Download Excel">
                                <i class="las la-file-excel text-success me-1"></i> Excel
                            </a>
                            <a href="{{ route('master-obat.export-csv', ['search' => request('search')]) }}" class="btn btn-export-tool" title="Download CSV">
                                <i class="las la-file-csv text-primary me-1"></i> CSV
                            </a>
                            <button type="button" onclick="window.print()" class="btn btn-export-tool" title="Print Data">
                                <i class="las la-print text-secondary me-1"></i> Print
                            </button>
                        </div>

                        {{-- Search Input --}}
                        <div>
                            <form action="{{ route('master-obat.index') }}" method="GET" class="d-inline-flex">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit"><i class="las la-search"></i></button>
                                    @if(request('search'))
                                        <a href="{{ route('master-obat.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="las la-times"></i></a>
                                    @endif
                                </div>
                            </form>
                        </div>

                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-master mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 180px;">Kode Obat/Logistik</th>
                                    <th>Nama Obat/Logistik</th>
                                    <th style="width: 200px;">Kode Kemkes</th>
                                    <th class="text-center" style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($masterObats as $item)
                                    <tr>
                                        {{-- 1. Kode Obat/Logistik --}}
                                        <td>
                                            <code class="text-dark fw-bold" style="font-size: 13.5px;">{{ $item->kode_obat }}</code>
                                            <span class="badge ms-1 bg-{{ $item->kategori == 'Obat' ? 'success' : 'info' }}-subtle text-{{ $item->kategori == 'Obat' ? 'success' : 'info' }} border">
                                                {{ $item->kategori }}
                                            </span>
                                        </td>

                                        {{-- 2. Nama Obat/Logistik --}}
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item->nama_obat }}</span>
                                            @if($item->deskripsi)
                                                <div class="text-muted small">{{ Str::limit($item->deskripsi, 50) }}</div>
                                            @endif
                                        </td>

                                        {{-- 3. Kode Kemkes --}}
                                        <td>
                                            @if($item->kode_kemkes)
                                                <span class="badge bg-secondary-subtle text-dark border px-2 py-1">
                                                    {{ $item->kode_kemkes }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        {{-- 4. Aksi (Edit & Hapus) --}}
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1 align-items-center">
                                                {{-- Edit Button (Warning/Kuning) --}}
                                                <a href="{{ route('master-obat.edit', $item->id) }}" class="btn btn-sm btn-warning text-white p-1 px-2" title="Edit">
                                                    <i class="las la-edit fs-16"></i>
                                                </a>

                                                {{-- Delete Button (Danger/Merah) --}}
                                                <form action="{{ route('master-obat.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus master obat/logistik ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger p-1 px-2" title="Hapus">
                                                        <i class="las la-times fs-16"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="las la-pills fs-36 d-block mb-2 text-secondary"></i>
                                            Belum ada data pada katalog Master Obat/Logistik.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Bottom Controls (Pagination) --}}
                    @if($masterObats->hasPages())
                        <div class="d-flex justify-content-end mt-3 pt-3 border-top">
                            {{ $masterObats->links('pagination::bootstrap-5') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection