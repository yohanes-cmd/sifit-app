@extends('layouts.app')
@section('title', 'Detail SBBK ' . $transaksi->nomor_surat . ' - SIFIT')

@push('css')
<style>
    @media print {
        /* Sembunyikan navigasi, header, sidebar, dan tombol saat mencetak */
        .page-title-box, .navbar, .left-sidenav, .sidebar, .btn, .breadcrumb, footer, .d-print-none {
            display: none !important;
        }
        body, .page-content, .container-fluid {
            background-color: #fff !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #333 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row d-print-none">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Surat Bukti Barang Keluar (SBBK)</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pengeluaran.index') }}">Pengeluaran Barang</a></li>
                            <li class="breadcrumb-item active">{{ $transaksi->nomor_surat }}</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="las la-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                        <button type="button" class="btn btn-primary" onclick="window.print()">
                            <i class="las la-print me-1"></i> Cetak Dokumen SBBK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-print-none" role="alert">
            <i class="las la-check-circle me-1 fs-5 align-middle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($transaksi->permohonan)
        <div class="alert alert-info border-0 shadow-sm d-print-none mb-3 d-flex justify-content-between align-items-center">
            <div>
                <i class="las la-link me-1 fs-5 align-middle"></i>
                Pengeluaran (SBBK) ini direalisasikan dari <strong>Permohonan OPD No: {{ $transaksi->permohonan->nomor_permohonan }}</strong> ({{ $transaksi->instansi->nama_opd ?? '-' }})
            </div>
            <a href="{{ route('permohonan.show', $transaksi->permohonan->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="las la-eye me-1"></i> Lihat Data Permohonan
            </a>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4" id="printableArea">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-0 fw-bold text-primary">
                            <i class="las la-file-invoice me-1"></i> SURAT BUKTI BARANG KELUAR (SBBK)
                        </h4>
                        <span class="text-muted small">Nomor: <strong>{{ $transaksi->nomor_surat }}</strong></span>
                    </div>
                    <span class="badge bg-success px-3 py-2 fs-6">
                        <i class="las la-check-circle me-1"></i> Terproses
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-muted small">Tanggal Pengeluaran</div>
                            <div class="fw-bold fs-6">{{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}</div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-muted small">Gudang Sumber (Asal)</div>
                            <div class="fw-bold fs-6 text-danger">
                                <i class="las la-warehouse me-1"></i>{{ $transaksi->gudangAsal->nama_gudang ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-muted small">Instansi Penerima (OPD)</div>
                            <div class="fw-bold fs-6 text-success">
                                <i class="las la-hospital me-1"></i>{{ $transaksi->instansi->nama_opd ?? '-' }}
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="text-muted small">Program Distribusi</div>
                            <div class="fw-bold fs-6">
                                <i class="las la-tag me-1 text-info"></i>{{ $transaksi->program->nama ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4 bg-light p-3 rounded mx-0">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="text-muted small">Petugas / Kurir Pengangkut</div>
                            <div class="fw-semibold">{{ $transaksi->pengangkut->nama ?? '-' }} {{ $transaksi->pengangkut->jenis_kendaraan ? '('.$transaksi->pengangkut->jenis_kendaraan.')' : '' }}</div>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="text-muted small">Pajak Faktur</div>
                            <div class="fw-semibold">{{ strtoupper($transaksi->pajak_invoice ?? 'NO TAX') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Diinput Oleh (Operator)</div>
                            <div class="fw-semibold">{{ $transaksi->user->name ?? '-' }}</div>
                        </div>
                    </div>

                    <h5 class="fw-bold text-dark mb-3"><i class="las la-boxes me-1"></i> Rincian Barang Keluar</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;" class="text-center">No</th>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat / Logistik</th>
                                    <th>Nomor Batch</th>
                                    <th>Kadaluarsa</th>
                                    <th>Satuan</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga Satuan (Rp)</th>
                                    <th class="text-end">Subtotal (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $subtotal = 0;
                                @endphp
                                @forelse($transaksi->detailTransaksis as $item)
                                    @php
                                        $rowTotal = $item->jumlah * ($item->harga_satuan ?? 0);
                                        $subtotal += $rowTotal;
                                        $obat = $item->masterObat;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td><code>{{ $obat->kode_obat ?? '-' }}</code></td>
                                        <td class="fw-semibold">{{ $obat->nama_obat ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                {{ $item->no_batch ?: '-' }}
                                            </span>
                                            @if($obat && $obat->kategori === 'Logistik' && $obat->kode_kemkes)
                                                <div class="text-muted small" style="font-size: 11px;"><i class="las la-tag me-1"></i>Kemkes: {{ $obat->kode_kemkes }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $item->exp_date ? \Carbon\Carbon::parse($item->exp_date)->format('d/m/Y') : '-' }}</td>
                                        <td>{{ $obat->satuan ?? '-' }}</td>
                                        <td class="text-center fw-bold">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($rowTotal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-3 text-muted">Tidak ada rincian item.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <div class="border rounded p-3 bg-light h-100">
                                <div class="fw-semibold mb-1"><i class="las la-comment-alt me-1"></i> Catatan SBBK:</div>
                                <p class="text-muted mb-0 small">{{ $transaksi->catatan ?: 'Tidak ada catatan khusus pada dokumen SBBK ini.' }}</p>
                            </div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <div class="border rounded p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal Item:</span>
                                    <span class="fw-semibold">Rp {{ number_format($transaksi->subtotal_items, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Pajak ({{ strtoupper($transaksi->pajak_invoice ?? 'NO TAX') }}):</span>
                                    <span class="fw-semibold text-info">Rp {{ number_format($transaksi->pajak_nominal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Biaya Kirim:</span>
                                    <span class="fw-semibold">Rp {{ number_format($transaksi->biaya_kirim ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold fs-6">Total Tagihan:</span>
                                    <span class="fw-bold fs-5 text-primary">Rp {{ number_format($transaksi->grand_total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lembar Tanda Tangan Resmi SBBK -->
                    <div class="row mt-5 pt-4 text-center">
                        <div class="col-3">
                            <div class="small text-muted mb-1">Yang Menyerahkan,</div>
                            <div class="small fw-semibold mb-5">Petugas Gudang Farmasi</div>
                            <div class="fw-bold">( _______________________ )</div>
                            <div class="small text-muted">NIP. </div>
                        </div>
                        <div class="col-3">
                            <div class="small text-muted mb-1">Pengangkut / Kurir,</div>
                            <div class="small fw-semibold mb-5">{{ $transaksi->pengangkut->nama ?? 'Petugas Ekspedisi' }}</div>
                            <div class="fw-bold">( _______________________ )</div>
                            <div class="small text-muted">No. Kendaraan: </div>
                        </div>
                        <div class="col-3">
                            <div class="small text-muted mb-1">Yang Menerima,</div>
                            <div class="small fw-semibold mb-5">{{ $transaksi->instansi->nama_opd ?? 'Pihak Penerima' }}</div>
                            <div class="fw-bold">( _______________________ )</div>
                            <div class="small text-muted">NIP. </div>
                        </div>
                        <div class="col-3">
                            <div class="small text-muted mb-1">Mengetahui,</div>
                            <div class="small fw-semibold mb-5">Kepala UPT / Pengelola</div>
                            <div class="fw-bold">( _______________________ )</div>
                            <div class="small text-muted">NIP. </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

