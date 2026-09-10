@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Master Obat / Logistik</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Katalog Master</h4>
                    <a href="{{ route('master-obat.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Master Obat
                    </a>
                </div>
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Kode Obat</th>
                                    <th>Nama Obat & Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <!-- TAMBAHAN KOLOM HARGA & STATUS -->
                                    <th>Harga</th>
                                    <th>Status Etalase</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($masterObats as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    
                                    <td class="text-center">
                                        @if($item->gambar)
                                            <img src="{{ asset($item->gambar) }}" alt="img" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <span class="badge bg-secondary">No Image</span>
                                        @endif
                                    </td>
                                    
                                    <td><strong>{{ $item->kode_obat }}</strong></td>
                                    
                                    <td>
                                        {{ $item->nama_obat }} <br>
                                        @if($item->deskripsi)
                                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($item->deskripsi, 40) }}</small>
                                        @endif
                                    </td>
                                    
                                    <td><span class="badge bg-{{ $item->kategori == 'Obat' ? 'success' : 'info' }}">{{ $item->kategori }}</span></td>
                                    <td>{{ $item->satuan }}</td>

                                    <!-- TAMPILAN HARGA FORMAT RUPIAH -->
                                    <td class="text-end">
                                        <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                                    </td>

                                    <!-- TAMPILAN STATUS PUBLISH & RESEP -->
                                    <td class="text-center">
                                        @if($item->status == 'published')
                                            <span class="badge bg-primary">Published</span>
                                        @elseif($item->status == 'draft')
                                            <span class="badge bg-warning text-dark">Draft</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif

                                        @if($item->requires_prescription)
                                            <br><small class="text-danger fw-bold"><i class="fas fa-file-medical"></i> Resep</small>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('master-obat.edit', $item->id) }}" class="btn btn-warning btn-sm mb-1"><i class="fas fa-edit"></i> Edit</a>
                                        <form action="{{ route('master-obat.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-1"><i class="fas fa-trash-alt"></i> Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <!-- Colspan disesuaikan jadi 9 karena ada tambahan kolom Harga dan Status -->
                                    <td colspan="9" class="text-center">Belum ada data Master Obat/Logistik.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection