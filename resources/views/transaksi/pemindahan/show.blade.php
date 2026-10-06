@extends('layouts.app')
@section('title', 'Detail Pemindahan - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Detail Pemindahan Barang</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pemindahan.index') }}">Pemindahan Barang</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('pemindahan.index') }}" class="btn btn-secondary">
                            <i class="las la-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="las la-file-alt me-2"></i> Surat Pemindahan: {{ $transaksi->nomor_surat }}
                    </h5>
                    <span class="badge bg-success px-3 py-2 fs-6">
                        <i class="las la-check-circle me-1"></i> Selesai
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Tanggal Transfer</div>
                            <div class="fw-bold fs-6">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d F Y') }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Gudang Asal</div>
                            <div class="fw-bold fs-6 text-danger">
                                <i class="las la-warehouse me-1"></i>{{ $transaksi->gudangAsal->nama_gudang ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Gudang Tujuan</div>
                            <div class="fw-bold fs-6 text-success">
                                <i class="las la-warehouse me-1"></i>{{ $transaksi->gudangTujuan->nama_gudang ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Catatan / Keterangan</div>
                            <div class="fw-bold fs-6">{{ $transaksi->catatan ?: '-' }}</div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-3">Daftar Item Barang Dipindahkan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat / Logistik</th>
                                    <th>Satuan</th>
                                    <th>Nomor Batch</th>
                                    <th class="text-end">Jumlah (Qty)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi->detailTransaksis as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $detail->masterObat->kode_obat ?? '-' }}</span></td>
                                    <td class="fw-semibold">{{ $detail->masterObat->nama_obat ?? '-' }}</td>
                                    <td>{{ $detail->masterObat->satuan ?? '-' }}</td>
                                    <td><code>{{ $detail->no_batch }}</code></td>
                                    <td class="text-end fw-bold text-primary">{{ number_format($detail->jumlah) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-3 text-muted">Tidak ada detail item pada transaksi ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-end fw-bold">Total Item:</th>
                                    <th class="text-end fw-bold text-primary">
                                        {{ number_format($transaksi->detailTransaksis->sum('jumlah')) }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
