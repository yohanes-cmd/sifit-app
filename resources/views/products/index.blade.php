@extends('layouts.app') <!-- Pastikan ini sesuai dengan nama file layout utama Anda -->

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">Manajemen Data Obat</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">SiFit E-Commerce</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
                <div class="col-auto align-self-center">
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-2"></i> Tambah Obat Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Katalog Produk & Obat</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 table-centered">
                        <thead class="thead-light">
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        <!-- Menampilkan gambar jika ada, jika tidak pakai placeholder -->
                                        <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('assets/images/users/user-1.jpg') }}" alt="" height="40" class="rounded mr-2">
                                        <p class="d-inline-block align-middle mb-0">
                                            <strong class="font-14">{{ $product->name }}</strong>
@if($product->requires_prescription)
    <span class="badge bg-soft-danger text-danger ml-1" title="Wajib Resep Dokter"><i class="las la-file-prescription"></i> Resep</span>
@endif </p>
                                    </td>
                                    <td>{{ $product->category ? $product->category->name : 'Tanpa Kategori' }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }} <span class="text-muted font-12">/ {{ $product->unit }}</span></td>
                                    <td>{{ $product->stock }} Pcs</td>
                                    <td>
    @if(trim($product->status) == 'published')
        <span class="badge bg-success text-white"><i class="las la-check mr-1"></i> Published</span>
    @elseif(trim($product->status) == 'draft')
        <span class="badge bg-secondary text-white"><i class="las la-minus mr-1"></i> Draft</span>
    @elseif(trim($product->status) == 'inactive')
        <span class="badge bg-danger text-white"><i class="las la-times mr-1"></i> Inactive</span>
    @else
        <span class="badge bg-dark text-white">Tidak Dikenali</span>
    @endif
    
</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}" class="mr-2" title="Edit">
                                            <i class="las la-pen text-info font-18"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0 bg-transparent p-0" onclick="return confirm('Yakin ingin menghapus obat ini?')" title="Delete">
                                                <i class="las la-trash-alt text-danger font-18"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        Belum ada data obat atau produk yang ditambahkan.
                                    </td>
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