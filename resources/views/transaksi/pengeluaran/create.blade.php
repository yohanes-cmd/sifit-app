@extends('layouts.app') 

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Transaksi Pengeluaran (SBBK)</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Surat Bukti Barang Keluar</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('pengeluaran.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Surat (SBBK) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_surat" placeholder="Contoh: OUT-2026-001" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keluarkan Dari Gudang <span class="text-danger">*</span></label>
                            <select class="form-select" name="gudang_asal_id" required>
                                <option value="">-- Pilih Gudang Sumber --</option>
                                @foreach($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}">{{ $gudang->nama_gudang }} ({{ strtoupper($gudang->tipe) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <h5 class="mb-3">Item Barang yang Dikeluarkan</h5>

                        <div class="mb-3">
                            <label class="form-label">Pilih Master Obat/Logistik <span class="text-danger">*</span></label>
                            <select class="form-select" name="master_obat_id" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($masterObats as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- BAGIAN INI DIBUAT JADI 3 KOLOM -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nomor Batch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_batch" placeholder="Contoh: BATCH001" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Expired Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="exp_date" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Jumlah Keluar <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="jumlah" min="1" placeholder="Contoh: 50" required>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-paper-plane"></i> Proses Pengeluaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection