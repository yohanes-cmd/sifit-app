@extends('layouts.app')
@section('title', 'Manajemen Galeri Dokumentasi - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Manajemen Galeri (Foto & Video)</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Galeri</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('galleries.create') }}" class="btn btn-primary">
                            <i class="las la-plus me-1"></i> Tambah Dokumentasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary">Daftar Foto & Video Dokumentasi Kegiatan</h5>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="las la-check-circle me-1 fs-5 align-middle"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 110px;">Media</th>
                                    <th>Judul Dokumentasi</th>
                                    <th style="width: 90px;" class="text-center">Tipe</th>
                                    <th>Keterangan</th>
                                    <th style="width: 90px;" class="text-center">Status</th>
                                    <th style="width: 130px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($galleries as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $galleries->firstItem() + $index }}</td>
                                        <td>
                                            @if($item->type === 'photo')
                                                <img src="{{ $item->media_url }}" alt="{{ $item->title }}" class="rounded border" style="width: 80px; height: 55px; object-fit: cover;">
                                            @else
                                                <div class="position-relative d-inline-block">
                                                    <img src="{{ $item->media_url }}" alt="{{ $item->title }}" class="rounded border" style="width: 80px; height: 55px; object-fit: cover;">
                                                    <span class="position-absolute top-50 start-50 translate-middle badge bg-danger rounded-circle p-1">
                                                        <i class="las la-play text-white"></i>
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-dark">
                                            {{ $item->title }}
                                            @if($item->youtube_url)
                                                <div class="small text-muted mt-1">
                                                    <i class="lab la-youtube text-danger"></i> <a href="{{ $item->youtube_url }}" target="_blank" class="text-decoration-none">YouTube Link</a>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($item->type === 'photo')
                                                <span class="badge bg-info"><i class="las la-camera"></i> Foto</span>
                                            @else
                                                <span class="badge bg-danger"><i class="las la-video"></i> Video</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ Str::limit($item->description, 80) ?? '-' }}</small>
                                        </td>
                                        <td class="text-center">
                                            @if($item->is_active)
                                                <span class="badge bg-success">Tayang</span>
                                            @else
                                                <span class="badge bg-secondary">Draft</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('galleries.edit', $item->id) }}" class="btn btn-sm btn-warning text-white" title="Ubah">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                <form action="{{ route('galleries.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            Belum ada foto atau video di galeri. Klik tombol "Tambah Dokumentasi".
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($galleries->hasPages())
                        <div class="d-flex justify-content-end mt-3">
                            {{ $galleries->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
