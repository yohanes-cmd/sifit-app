@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">Tambah Obat Baru</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
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
            <div class="card-header">
                <h4 class="card-title">Form Input Data Obat</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Obat / Produk <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required placeholder="Misal: Paracetamol 500mg">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Baris ini dibagi menjadi 4 kolom menyamping menggunakan col-md-3 -->
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" required placeholder="Misal: 15000">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Satuan <span class="text-danger">*</span></label>
                                <select name="unit" class="form-control" required>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Strip">Strip</option>
                                    <option value="Kotak">Kotak</option>
                                    <option value="Botol">Botol</option>
                                    <option value="Tube">Tube</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" required placeholder="Misal: 100">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="published">Published (Tampil di Web)</option>
                                    <option value="draft">Draft (Simpan Sementara)</option>
                                    <option value="inactive">Inactive (Tidak Aktif)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi Obat</label>
                                <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan indikasi, dosis, dan efek samping..."></textarea>
                            </div>
                        </div>
                    </div>

                  <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foto Produk (Opsional)</label>
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <!-- Switch bergaya Dastone -->
                            <div class="custom-control custom-switch switch-danger mt-2">
                                <input type="checkbox" class="custom-control-input" id="requiresPrescription" name="requires_prescription" value="1">
                                <label class="custom-control-label font-weight-bold" for="requiresPrescription">Obat Keras (Wajib Resep Dokter)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahan mb-3 (margin-bottom) agar tombol tidak mepet ke bawah -->
                    <div class="row mt-4 mb-3">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection