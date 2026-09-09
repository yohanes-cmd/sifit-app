@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Edit Master Obat / Logistik</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Ubah Data</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('master-obat.update', $masterObat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="kode_obat" class="form-label">Kode Obat/Logistik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_obat') is-invalid @enderror" id="kode_obat" name="kode_obat" value="{{ old('kode_obat', $masterObat->kode_obat) }}" required>
                            @error('kode_obat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat/Logistik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat" name="nama_obat" value="{{ old('nama_obat', $masterObat->nama_obat) }}" required>
                            @error('nama_obat') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                <option value="Obat" {{ old('kategori', $masterObat->kategori) == 'Obat' ? 'selected' : '' }}>Obat</option>
                                <option value="Logistik" {{ old('kategori', $masterObat->kategori) == 'Logistik' ? 'selected' : '' }}>Logistik Medis / Alkes</option>
                            </select>
                            @error('kategori') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', $masterObat->satuan) }}" required>
                            @error('satuan') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('master-obat.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Perbarui Master Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection