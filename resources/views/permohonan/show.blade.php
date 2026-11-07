@extends('layouts.app')
@section('title', 'Detail Permohonan ' . $permohonan->nomor_permohonan . ' - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Detail Pengajuan Permohonan Obat</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">Permohonan</a></li>
                            <li class="breadcrumb-item active">{{ $permohonan->nomor_permohonan }}</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center d-flex gap-2">
                        <a href="{{ route('permohonan.index') }}" class="btn btn-outline-secondary">
                            <i class="las la-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                        @can('permohonan-print')
                        <a href="{{ route('permohonan.print', $permohonan->id) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="las la-print me-1"></i> Cetak Surat Permohonan
                        </a>
                        @endcan

                        @can('pengeluaran-create')
                            @if(in_array($permohonan->status, ['disetujui', 'menunggu']) && !$permohonan->transaksi)
                                <a href="{{ route('pengeluaran.create', ['permohonan_id' => $permohonan->id]) }}" class="btn btn-success fw-bold shadow-sm">
                                    <i class="las la-dolly me-1"></i> Proses Pengeluaran (SBBK)
                                </a>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="las la-check-circle me-1 fs-5 align-middle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="las la-exclamation-circle me-1 fs-5 align-middle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($permohonan->status === 'selesai' && $permohonan->transaksi)
        <div class="alert alert-success border-0 shadow-sm d-flex justify-content-between align-items-center mb-4">
            <div>
                <i class="las la-check-double fs-4 me-2 align-middle"></i>
                <strong>Permohonan ini telah selesai dan direalisasikan ke SBBK!</strong>
                <span class="d-block small text-muted mt-1">Nomor Surat SBBK: <strong>{{ $permohonan->transaksi->nomor_surat }}</strong> | Tanggal: {{ \Carbon\Carbon::parse($permohonan->transaksi->tanggal)->translatedFormat('d F Y') }}</span>
            </div>
            <a href="{{ route('pengeluaran.show', $permohonan->transaksi->id) }}" class="btn btn-sm btn-primary">
                <i class="las la-file-invoice me-1"></i> Lihat Dokumen SBBK
            </a>
        </div>
    @endif

    <div class="row">
        <!-- Informasi Permohonan -->
        <div class="col-lg-4 col-md-12 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="las la-file-alt me-1"></i> Informasi Pengajuan
                    </h5>
                    {!! $permohonan->status_badge !!}
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <span class="text-muted small d-block">Nomor Permohonan</span>
                        <strong class="fs-6 text-dark">{{ $permohonan->nomor_permohonan }}</strong>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Tanggal Pengajuan</span>
                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->translatedFormat('d F Y') }}</span>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Instansi Pemohon (OPD)</span>
                        <span class="fw-bold text-primary fs-6">{{ $permohonan->opd->nama_opd ?? '-' }}</span>
                        @if($permohonan->opd && $permohonan->opd->alamat)
                            <small class="d-block text-muted">{{ $permohonan->opd->alamat }}</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Akun Pengaju / Pemohon</span>
                        <span class="fw-semibold">{{ $permohonan->user->name ?? '-' }}</span>
                        <small class="text-muted">({{ $permohonan->user->email ?? '-' }})</small>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Keperluan / Program</span>
                        <span>{{ $permohonan->keperluan ?: '-' }}</span>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Surat Pengantar OPD</span>
                        @if($permohonan->surat_pengantar)
                            <a href="{{ asset('storage/' . $permohonan->surat_pengantar) }}" target="_blank" class="btn btn-sm btn-outline-info mt-1">
                                <i class="las la-paperclip me-1"></i> Unduh / Buka Dokumen Lampiran
                            </a>
                        @else
                            <span class="text-muted font-italic">Tidak ada lampiran berkas</span>
                        @endif
                    </div>

                    <div class="mb-0">
                        <span class="text-muted small d-block">Catatan Pemohon</span>
                        <div class="p-2 bg-light rounded text-secondary small mt-1">
                            {{ $permohonan->catatan ?: 'Tidak ada catatan khusus.' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Status Verifikasi -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="las la-clipboard-check me-1"></i> Riwayat Verifikasi
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($permohonan->verified_by)
                        <div class="mb-3">
                            <span class="text-muted small d-block">Diverifikasi Oleh</span>
                            <span class="fw-semibold">{{ $permohonan->verifiedBy->name ?? 'Petugas Farmasi' }}</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-muted small d-block">Waktu Verifikasi</span>
                            <span>{{ $permohonan->verified_at ? $permohonan->verified_at->translatedFormat('d F Y, H:i') : '-' }} WIB</span>
                        </div>
                        <div class="mb-0">
                            <span class="text-muted small d-block">Catatan Petugas</span>
                            <div class="p-2 bg-light rounded small mt-1 text-dark">
                                {{ $permohonan->catatan_verifikasi ?: '-' }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="las la-hourglass-half fs-2 text-warning mb-2 d-block"></i>
                            Menunggu pemeriksaan dan verifikasi dari Petugas Pengelola Obat.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabel Rincian Obat (Acuan Barang) & Panel Verifikasi -->
        <div class="col-lg-8 col-md-12 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="las la-boxes me-1"></i> Acuan Barang Dimohonkan
                        </h5>
                        <span class="text-muted small">Daftar item obat beserta ketersediaan stok fisik gudang terkini</span>
                    </div>
                    <span class="badge bg-light text-dark border">
                        {{ $permohonan->detailPermohonans->count() }} Jenis Obat
                    </span>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="4%">No</th>
                                    <th>Nama Obat / Logistik</th>
                                    <th>Satuan</th>
                                    <th class="text-center">Jumlah Diminta</th>
                                    <th class="text-center">Jumlah Disetujui</th>
                                    <th class="text-center">Stok Fisik Gudang</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permohonan->detailPermohonans as $idx => $detail)
                                    @php
                                        $obat = $detail->masterObat;
                                        $stokTersediaFisik = $stokTersedia[$detail->master_obat_id] ?? 0;
                                        $cukup = $stokTersediaFisik >= $detail->jumlah_diminta;
                                    @endphp
                                    <tr>
                                        <td>{{ $idx + 1 }}</td>
                                        <td>
                                            <strong class="text-dark">{{ $obat->nama_obat ?? '-' }}</strong>
                                            <small class="d-block text-muted">
                                                Kode: {{ $obat->kode_obat ?? '-' }}
                                                @if($obat && $obat->kode_kemkes)
                                                    | {{ $obat->kategori === 'Logistik' ? 'Kemkes: ' : 'Batch: ' }}{{ $obat->kode_kemkes }}
                                                @endif
                                            </small>
                                        </td>
                                        <td>{{ $obat->satuan ?? 'Pcs' }}</td>
                                        <td class="text-center fw-bold fs-6">
                                            {{ number_format($detail->jumlah_diminta) }}
                                        </td>
                                        <td class="text-center fw-bold fs-6 text-primary">
                                            {{ number_format($detail->jumlah_disetujui ?? $detail->jumlah_diminta) }}
                                        </td>
                                        <td class="text-center">
                                            @if($stokTersediaFisik > 0)
                                                <span class="badge {{ $cukup ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ number_format($stokTersediaFisik) }} {{ $obat->satuan ?? 'Pcs' }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger">Habis (0)</span>
                                            @endif
                                        </td>
                                        <td>{{ $detail->catatan ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr class="fw-bold">
                                    <td colspan="3" class="text-end">Total Kuantitas:</td>
                                    <td class="text-center fs-6">{{ number_format($permohonan->total_diminta) }}</td>
                                    <td class="text-center fs-6 text-primary">{{ number_format($permohonan->total_disetujui) }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form Verifikasi (Hanya Muncul untuk pengguna dengan hak akses permohonan-verify jika belum selesai) -->
            @can('permohonan-verify')
                @if($permohonan->status !== 'selesai')
                <div class="card shadow-sm border-0 border-top border-primary border-3">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="las la-check-circle me-1"></i> Form Verifikasi & Penyesuaian Kuantitas (Admin Farmasi)
                        </h5>
                        <span class="text-muted small">Tentukan status persetujuan dan jumlah alokasi obat yang disetujui</span>
                    </div>
                    <form action="{{ route('permohonan.verifikasi', $permohonan->id) }}" method="POST">
                        @csrf
                        <div class="card-body p-4">
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Keputusan Status Permohonan <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="disetujui" {{ $permohonan->status === 'disetujui' ? 'selected' : '' }}>
                                             Setujui Permohonan (Siap SBBK)
                                        </option>
                                        <option value="diproses" {{ $permohonan->status === 'diproses' ? 'selected' : '' }}>
                                            Sedang Diproses / Disiapkan
                                        </option>
                                        <option value="ditolak" {{ $permohonan->status === 'ditolak' ? 'selected' : '' }}>
                                            Tolak Permohonan
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Catatan / Alasan Verifikasi</label>
                                    <input type="text" name="catatan_verifikasi" class="form-control" placeholder="Contoh: Disetujui penuh sesuai ketersediaan stok UPT..." value="{{ old('catatan_verifikasi', $permohonan->catatan_verifikasi) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Sesuaikan Kuantitas Disetujui (Opsional Jika Ada Revisi Alokasi):</label>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Obat</th>
                                                <th class="text-center" width="20%">Jumlah Diminta</th>
                                                <th class="text-center" width="25%">Jumlah Disetujui</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($permohonan->detailPermohonans as $detail)
                                                <tr>
                                                    <td>{{ $detail->masterObat->nama_obat ?? '-' }}</td>
                                                    <td class="text-center">{{ number_format($detail->jumlah_diminta) }} {{ $detail->masterObat->satuan ?? 'Pcs' }}</td>
                                                    <td>
                                                        <input type="number" name="disetujui[{{ $detail->id }}]" class="form-control form-control-sm text-center" min="0" value="{{ $detail->jumlah_disetujui ?? $detail->jumlah_diminta }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white py-3 border-top d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary fw-bold px-4">
                                <i class="las la-save me-1"></i> Simpan Hasil Verifikasi
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
