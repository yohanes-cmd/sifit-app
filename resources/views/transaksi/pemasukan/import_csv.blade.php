@extends('layouts.app')
@section('title', 'Tambahkan Pemasukan dengan CSV - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tambahkan Pemasukan dengan CSV</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pemasukan.index') }}">Daftar Pemasukan</a></li>
                            <li class="breadcrumb-item active">Import CSV</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="las la-file-csv me-2"></i> Import Data Pemasukan dari File CSV
                    </h5>
                    <a href="{{ route('pemasukan.download-template-csv') }}" class="btn btn-sm btn-outline-success">
                        <i class="las la-download me-1"></i> Download Template CSV
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="las la-check-circle me-1"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="las la-exclamation-circle me-1"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <h6 class="fw-bold mb-2"><i class="las la-info-circle me-1"></i> Petunjuk Import CSV</h6>
                        <ol class="mb-0 small">
                            <li>Klik tombol <strong>"Download Template CSV"</strong> untuk mendapatkan format file yang benar.</li>
                            <li>Buka file template di Excel atau Google Sheets, isi data pemasukan.</li>
                            <li>Simpan kembali sebagai format <code>.csv</code>.</li>
                            <li>Upload file di form di bawah ini, lalu klik <strong>"Upload & Import"</strong>.</li>
                        </ol>
                    </div>

                    <div class="card border mb-4">
                        <div class="card-header bg-light py-2">
                            <small class="fw-bold text-muted">Format Kolom CSV (urutan harus sesuai)</small>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kolom</th>
                                        <th>Keterangan</th>
                                        <th>Wajib?</th>
                                        <th>Contoh</th>
                                    </tr>
                                </thead>
                                <tbody class="small">
                                    <tr><td><code>nomor_surat</code></td><td>Nomor surat / dokumen pemasukan</td><td><span class="badge bg-danger">Ya</span></td><td>SURAT-001</td></tr>
                                    <tr><td><code>tanggal</code></td><td>Tanggal transaksi (YYYY-MM-DD)</td><td><span class="badge bg-danger">Ya</span></td><td>{{ date('Y-m-d') }}</td></tr>
                                    <tr><td><code>gudang_id</code></td><td>ID Gudang penerima</td><td><span class="badge bg-danger">Ya</span></td><td>1</td></tr>
                                    <tr><td><code>pemasok_id</code></td><td>ID Pemasok / sumber barang</td><td><span class="badge bg-secondary">Opsional</span></td><td>1</td></tr>
                                    <tr><td><code>kode_obat</code></td><td>Kode obat dari Master Obat</td><td><span class="badge bg-danger">Ya</span></td><td>OBT-001</td></tr>
                                    <tr><td><code>no_batch</code></td><td>Nomor batch barang</td><td><span class="badge bg-danger">Ya</span></td><td>BATCH-001</td></tr>
                                    <tr><td><code>exp_date</code></td><td>Tanggal kadaluarsa (YYYY-MM-DD)</td><td><span class="badge bg-danger">Ya</span></td><td>{{ date('Y') }}-12-31</td></tr>
                                    <tr><td><code>jumlah</code></td><td>Jumlah/kuantitas barang</td><td><span class="badge bg-danger">Ya</span></td><td>100</td></tr>
                                    <tr><td><code>catatan</code></td><td>Keterangan tambahan</td><td><span class="badge bg-secondary">Opsional</span></td><td>Pengadaan APBD</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-warning small">
                        <i class="las la-lightbulb me-1"></i>
                        <strong>Tips:</strong> Baris dengan <strong>nomor_surat yang sama</strong> akan digabung menjadi <strong>1 transaksi pemasukan</strong> dengan banyak item.
                        Baris yang <code>kode_obat</code>-nya tidak ada di Master Obat akan dilewati secara otomatis.
                    </div>

                    <form action="{{ route('pemasukan.import-csv') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih File CSV <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="csv_file" accept=".csv, .txt" required>
                            <div class="form-text">Maksimal ukuran file: 10MB. Format: .csv atau .txt</div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="las la-file-upload me-1"></i> Upload & Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
