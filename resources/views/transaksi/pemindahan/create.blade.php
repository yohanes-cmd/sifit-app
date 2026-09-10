@extends('layouts.app') 

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Transaksi Pemindahan Antar Gudang</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Surat Pemindahan Barang</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('pemindahan.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Transfer <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Surat Pemindahan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_surat" placeholder="Contoh: TR-2026-001" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dari Gudang (Asal) <span class="text-danger">*</span></label>
                                <select class="form-select" name="gudang_asal_id" required>
                                    <option value="">-- Pilih Gudang Sumber --</option>
                                    @foreach($gudangs as $gudang)
                                        <option value="{{ $gudang->id }}">{{ $gudang->nama_gudang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ke Gudang (Tujuan) <span class="text-danger">*</span></label>
                                <select class="form-select" name="gudang_tujuan_id" required>
                                    <option value="">-- Pilih Gudang Penerima --</option>
                                    @foreach($gudangs as $gudang)
                                        <option value="{{ $gudang->id }}">{{ $gudang->nama_gudang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3">Item Barang yang Dipindahkan</h5>

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
                                <label class="form-label">Jumlah Dipindahkan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="jumlah" min="1" required>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-info text-white"><i class="fas fa-exchange-alt"></i> Proses Pemindahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection