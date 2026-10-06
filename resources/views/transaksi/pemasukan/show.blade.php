@extends('layouts.app')
@section('title', 'Detail Transaksi Pemasukan - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Detail Transaksi Pemasukan</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pemasukan.index') }}">Daftar Pemasukan</a></li>
                            <li class="breadcrumb-item active">Detail Pemasukan</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary">
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
                        <i class="las la-file-invoice me-2"></i> Nomor Surat: {{ $transaksi->nomor_surat }}
                    </h5>
                    <span class="badge bg-success px-3 py-2 fs-6">
                        <i class="las la-check-circle me-1"></i> Pemasukan Berhasil
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Tanggal Pemasukan</div>
                            <div class="fw-bold fs-6">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d F Y') }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Gudang Penerima</div>
                            <div class="fw-bold fs-6 text-success">
                                <i class="las la-warehouse me-1"></i>{{ $transaksi->gudangTujuan->nama_gudang ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Sumber / Pemasok</div>
                            <div class="fw-bold fs-6 text-info">
                                <i class="las la-building me-1"></i>{{ $transaksi->pemasok->nama_pemasok ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-muted fs-7">Petugas Input</div>
                            <div class="fw-bold fs-6">{{ $transaksi->user->name ?? '-' }}</div>
                        </div>
                    </div>

                    @if($transaksi->catatan)
                    <div class="alert alert-light border mb-4">
                        <span class="fw-bold"><i class="las la-sticky-note me-1"></i>Catatan:</span> {{ $transaksi->catatan }}
                    </div>
                    @endif

                    <h5 class="fw-bold text-dark mb-3">Daftar Item Barang Masuk</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat / Logistik</th>
                                    <th>Satuan</th>
                                    <th>Nomor Batch</th>
                                    <th>Expired Date</th>
                                    <th class="text-end">Jumlah Barang</th>
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
                                    <td>
                                        @if($detail->exp_date)
                                            <span class="badge bg-warning text-dark">
                                                {{ \Carbon\Carbon::parse($detail->exp_date)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold text-primary">{{ number_format($detail->jumlah) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3 text-muted">Tidak ada detail item pada transaksi ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" class="text-end fw-bold">Total Kuantitas Barang:</th>
                                    <th class="text-end fw-bold text-primary fs-6">
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
