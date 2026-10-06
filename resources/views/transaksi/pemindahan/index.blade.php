@extends('layouts.app')
@section('title', 'Daftar Pemindahan - SIFIT')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Daftar Pemindahan Antar Gudang</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pemindahan Barang</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('pemindahan.create') }}" class="btn btn-primary">
                            <i class="las la-plus me-1"></i> Tambah Pemindahan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary">Daftar Surat Pemindahan</h5>

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
                                    <th style="width: 50px;">No</th>
                                    <th>Tanggal</th>
                                    <th>Nomor Surat</th>
                                    <th>Gudang Asal</th>
                                    <th>Gudang Tujuan</th>
                                    <th class="text-center">Total Item</th>
                                    <th>Catatan</th>
                                    <th style="width: 120px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td><span class="fw-semibold text-primary">{{ $item->nomor_surat }}</span></td>
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
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $item->detail_transaksis_count ?? $item->detailTransaksis->count() }} Item</span>
                                    </td>
                                    <td>{{ Str::limit($item->catatan ?? '-', 40) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pemindahan.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                            <i class="las la-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">
                                        <i class="las la-inbox la-3x d-block mb-2"></i>
                                        Belum ada data transaksi pemindahan.
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
