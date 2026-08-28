@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">Tambah Kategori</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required placeholder="Misal: Vitamin & Suplemen">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Kategori <span class="text-danger">*</span></label>
                                <select name="type" class="form-control" required>
                                    <option value="product">Produk / Obat</option>
                                    <option value="news">Berita</option>
                                    <option value="information">Informasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ikon / Gambar Kategori (Opsional)</label>
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                                <small class="text-muted">Gunakan gambar persegi (rasio 1:1) dengan *background* transparan atau putih agar rapi seperti K24.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-3">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection