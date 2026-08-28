@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">Edit Kategori</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
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
                <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tipe Kategori <span class="text-danger">*</span></label>
                                <select name="type" class="form-control" required>
                                    <option value="product" {{ $category->type == 'product' ? 'selected' : '' }}>Produk / Obat</option>
                                    <option value="news" {{ $category->type == 'news' ? 'selected' : '' }}>Berita</option>
                                    <option value="information" {{ $category->type == 'information' ? 'selected' : '' }}>Informasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Ganti Ikon / Gambar (Opsional)</label><br>
                                @if($category->image)
                                    <img src="{{ asset('storage/'.$category->image) }}" alt="Ikon Lama" height="60" class="mb-2 border rounded p-1">
                                @endif
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah ikon.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4 mb-3">
                        <div class="col-md-12 text-right">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-info">Update Kategori</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection