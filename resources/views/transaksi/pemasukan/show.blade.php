@extends('layouts.app')
@section('title', 'Detail Penerimaan Barang - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Detail Penerimaan / Pemasukan Barang</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pemasukan.index') }}">Daftar Pemasukan</a></li>
                            <li class="breadcrumb-item active">{{ $transaksi->nomor_surat }}</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center d-flex gap-2">
                        <a href="{{ route('pemasukan.index') }}" class="btn btn-outline-secondary">
                            <i class="las la-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                        <a href="{{ route('pengeluaran.show', $transaksi->id) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="las la-print me-1"></i> Cetak Dokumen Penerimaan / SBBK
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
                    <div>
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="las la-file-invoice me-2"></i> Nomor Surat: {{ $transaksi->nomor_surat }}
                        </h5>
                        @if($transaksi->permohonan)
                            <small class="text-muted">Realisasi dari Permohonan: <strong>{{ $transaksi->permohonan->nomor_permohonan }}</strong></small>
                        @endif
                    </div>
                    <span class="badge bg-success px-3 py-2 fs-6">
                        <i class="las la-check-circle me-1"></i> Telah Diterima
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Tanggal Penerimaan</div>
                            <div class="fw-bold fs-6">{{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}</div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Sumber / Pengirim</div>
                            <div class="fw-bold fs-6 text-primary">
                                <i class="las la-warehouse me-1"></i>{{ $transaksi->gudangAsal->nama_gudang ?? ($transaksi->pemasok->nama_pemasok ?? 'Gudang Farmasi Pusat') }}
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Instansi Penerima</div>
                            <div class="fw-bold fs-6 text-success">
                                <i class="las la-hospital me-1"></i>{{ $transaksi->instansi->nama_opd ?? ($transaksi->gudangTujuan->nama_gudang ?? '-') }}
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="text-muted small">Petugas Pencatat</div>
                            <div class="fw-bold fs-6">{{ $transaksi->user->name ?? '-' }}</div>
                        </div>
                    </div>

                    @if($transaksi->catatan)
                    <div class="alert alert-light border mb-4">
                        <span class="fw-bold"><i class="las la-sticky-note me-1"></i>Catatan:</span> {{ $transaksi->catatan }}
                    </div>
                    @endif

                    <h5 class="fw-bold text-dark mb-3"><i class="las la-boxes text-primary me-1"></i> Rincian Item Obat yang Diterima</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat / Logistik</th>
                                    <th>Satuan</th>
                                    <th>Nomor Batch</th>
                                    <th>Expired Date</th>
                                    <th class="text-end">Jumlah Diterima</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi->detailTransaksis as $detail)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $detail->masterObat->kode_obat ?? '-' }}</span></td>
                                    <td class="fw-semibold text-dark">{{ $detail->masterObat->nama_obat ?? '-' }}</td>
                                    <td>{{ $detail->masterObat->satuan ?? 'Pcs' }}</td>
                                    <td>
                                        <code>{{ $detail->no_batch ?: '-' }}</code>
                                        @if($detail->masterObat && $detail->masterObat->kategori === 'Logistik' && $detail->masterObat->kode_kemkes)
                                            <div class="text-muted small" style="font-size: 11px;"><i class="las la-tag me-1"></i>Kemkes: {{ $detail->masterObat->kode_kemkes }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($detail->exp_date)
                                            <span class="badge bg-warning text-dark">
                                                {{ \Carbon\Carbon::parse($detail->exp_date)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold text-primary fs-6">{{ number_format($detail->jumlah) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">Tidak ada detail item pada transaksi ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th colspan="6" class="text-end fw-bold">Total Kuantitas Obat Diterima:</th>
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
