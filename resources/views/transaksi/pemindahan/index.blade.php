@php
    $currentUser = auth()->user();
    $isOpd = isset($isOpd) ? $isOpd : ($currentUser && $currentUser->isAdminOpd());
@endphp

@extends('layouts.app')
@section('title', ($isOpd ? 'Mutasi Obat OPD' : 'Daftar Pemindahan Antar Gudang') . ' - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">{{ $isOpd ? 'Pemindahan & Mutasi Obat Internal OPD' : 'Daftar Pemindahan Antar Gudang' }}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pemindahan Barang</li>
                        </ol>
                    </div>
                    @can('pemindahan-create')
                    <div class="col-auto align-self-center">
                        <a href="{{ route('pemindahan.create') }}" class="btn btn-primary">
                            <i class="las la-plus me-1"></i> {{ $isOpd ? 'Tambah Mutasi Internal' : 'Tambah Pemindahan' }}
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-primary">
                            <i class="las la-exchange-alt me-1"></i> {{ $isOpd ? 'Daftar Mutasi Obat Antar Ruangan / Sub-Unit' : 'Daftar Surat Pemindahan Antar Gudang' }}
                        </h5>
                        <p class="text-muted small mb-0">
                            {{ $isOpd ? 'Pencatatan pergeseran stok obat di lingkungan fasilitas kesehatan OPD.' : 'Mutasi stok obat antar gudang farmasi pusat.' }}
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Tanggal</th>
                                    <th>Nomor Surat / Mutasi</th>
                                    @if($isOpd)
                                        <th>Rincian Mutasi / Ruangan</th>
                                    @else
                                        <th>Gudang Asal</th>
                                        <th>Gudang Tujuan</th>
                                        <th>Catatan</th>
                                    @endif
                                    <th class="text-center">Total Item</th>
                                    <th style="width: 120px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('pemindahan.show', $item->id) }}" class="fw-semibold text-primary">
                                            {{ $item->nomor_surat }}
                                        </a>
                                    </td>

                                    @if($isOpd)
                                        <td>
                                            <span class="text-dark">{{ $item->catatan ?: 'Mutasi Ruangan Internal' }}</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge bg-secondary">
                                                <i class="las la-warehouse me-1"></i>{{ $item->gudangAsal->nama_gudang ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                <i class="las la-warehouse me-1"></i>{{ $item->gudangTujuan->nama_gudang ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($item->catatan ?? '-', 40) }}</td>
                                    @endif

                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $item->detail_transaksis_count ?? $item->detailTransaksis->count() }} Jenis</span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('pemindahan.show', $item->id) }}" class="btn btn-outline-info" title="Lihat Detail">
                                                <i class="las la-eye"></i> Detail
                                            </a>
                                            @can('pemindahan-delete')
                                            <button type="button" class="btn btn-outline-danger" title="Hapus" onclick="deleteSingle('{{ route('pemindahan.destroy', $item->id) }}')">
                                                <i class="las la-trash"></i>
                                            </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ $isOpd ? 6 : 8 }}" class="text-center py-5 text-muted">
                                        <i class="las la-inbox la-3x d-block mb-2 text-secondary"></i>
                                        Belum ada data transaksi pemindahan / mutasi obat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($transaksis, 'links'))
                        <div class="d-flex justify-content-end mt-3">
                            {{ $transaksis->links() }}
                        </div>
                    @endif
                    
                    <!-- Hidden single delete form -->
                    <form id="formSingleDelete" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteSingle(url) {
        if (confirm('Apakah Anda yakin ingin menghapus data pemindahan ini?')) {
            const form = document.getElementById('formSingleDelete');
            form.action = url;
            form.submit();
        }
    }
</script>
@endpush
