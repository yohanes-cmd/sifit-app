@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">Edit Data Obat</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Obat / Produk <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
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
                                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Satuan <span class="text-danger">*</span></label>
                                <select name="unit" class="form-control" required>
                                    <option value="Pcs" {{ $product->unit == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="Strip" {{ $product->unit == 'Strip' ? 'selected' : '' }}>Strip</option>
                                    <option value="Kotak" {{ $product->unit == 'Kotak' ? 'selected' : '' }}>Kotak</option>
                                    <option value="Botol" {{ $product->unit == 'Botol' ? 'selected' : '' }}>Botol</option>
                                    <option value="Tube" {{ $product->unit == 'Tube' ? 'selected' : '' }}>Tube</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stok <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="published" {{ $product->status == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deskripsi Obat</label>
                                <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ganti Foto (Opsional)</label><br>
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="Foto Lama" height="80" class="mb-2 rounded">
                                @endif
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            </div>
                        </div>
                        <div class="col-md-6 align-self-center">
                            <div class="custom-control custom-switch switch-danger mt-2">
                                <input type="checkbox" class="custom-control-input" id="requiresPrescription" name="requires_prescription" value="1" {{ $product->requires_prescription ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="requiresPrescription">Obat Keras (Wajib Resep Dokter)</label>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahan mb-3 (margin-bottom) agar tombol tidak mepet ke bawah bingkai -->
                    <div class="row mt-4 mb-3">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-info">Update Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection