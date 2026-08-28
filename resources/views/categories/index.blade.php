@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">Manajemen Kategori</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">SiFit</a></li>
                        <li class="breadcrumb-item active">Kategori</li>
                    </ol>
                </div>
                <div class="col-auto align-self-center">
                    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-2"></i>Tambah Kategori
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success border-0" role="alert">
                <strong>Sukses!</strong> {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 table-centered">
                        <thead>
                            <tr>
                                <th width="10%">Ikon</th>
                                <th>Nama Kategori</th>
                                <th>Tipe</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="text-center">
                                    @if($category->image)
                                        <img src="{{ asset('storage/'.$category->image) }}" alt="ikon" height="40" class="rounded">
                                    @else
                                        <span class="badge bg-light text-dark">Tanpa Ikon</span>
                                    @endif
                                </td>
                                <td><strong class="font-14">{{ $category->name }}</strong></td>
                                <td>
                                    @if($category->type == 'product')
                                        <span class="badge bg-soft-primary text-primary">Produk / Obat</span>
                                    @elseif($category->type == 'news')
                                        <span class="badge bg-soft-info text-info">Berita</span>
                                    @else
                                        <span class="badge bg-soft-secondary text-secondary">Informasi</span>
                                    @endif
                                </td>
                                <td class="text-center">
    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
        <!-- Ikon diganti menggunakan Line Awesome (las la-pen) -->
        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-soft-success btn-circle mr-2">
            <i class="las la-pen font-16"></i>
        </a>

        @csrf
        @method('DELETE')

        <!-- Ikon diganti menggunakan Line Awesome (las la-trash) -->
        <button type="submit" class="btn btn-sm btn-soft-danger btn-circle">
            <i class="las la-trash font-16"></i>
        </button>
    </form>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data kategori.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection