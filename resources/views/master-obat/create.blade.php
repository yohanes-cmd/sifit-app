@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Tambah Master Obat / Logistik</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Input Katalog</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('master-obat.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kode_obat" class="form-label">Kode Obat/Logistik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_obat') is-invalid @enderror" id="kode_obat" name="kode_obat" value="{{ old('kode_obat') }}" placeholder="Contoh: OBT001" required>
                            @error('kode_obat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat/Logistik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}" placeholder="Contoh: Paracetamol 500mg" required>
                            @error('nama_obat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Obat" {{ old('kategori') == 'Obat' ? 'selected' : '' }}>Obat</option>
                                <option value="Logistik" {{ old('kategori') == 'Logistik' ? 'selected' : '' }}>Logistik Medis / Alkes</option>
                            </select>
                            @error('kategori') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: Strip, Kotak, Vial" required>
                            @error('satuan') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('master-obat.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Master Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection