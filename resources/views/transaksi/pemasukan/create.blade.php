@extends('layouts.app') 

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Transaksi Pemasukan</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Tambah Pemasukan Obat/Logistik</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('pemasukan.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Pemasukan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Surat / Faktur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_surat" placeholder="Contoh: INV-2026-001" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gudang Penerima <span class="text-danger">*</span></label>
                            <select class="form-select" name="gudang_tujuan_id" required>
                                <option value="">-- Pilih Gudang --</option>
                                @foreach($gudangs as $gudang)
                                    <option value="{{ $gudang->id }}">{{ $gudang->nama_gudang }} ({{ strtoupper($gudang->tipe) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <h5 class="mb-3">Item Barang</h5>

                        <div class="mb-3">
                            <label class="form-label">Pilih Master Obat/Logistik <span class="text-danger">*</span></label>
                            <select class="form-select" name="master_obat_id" required>
                                <option value="">-- Pilih Barang dari Katalog --</option>
                                @foreach($masterObats as $obat)
                                    <option value="{{ $obat->id }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Batch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="no_batch" placeholder="Contoh: BATCH001" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="jumlah" min="1" placeholder="Contoh: 500" required>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Transaksi Pemasukan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection