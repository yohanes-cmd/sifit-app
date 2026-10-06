@extends('layouts.app')

@section('title', 'Status Kepemilikan - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Pengaturan Status Kepemilikan (Kantor 1 / 2)</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">Status Kepemilikan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="las la-check-circle me-1 fs-5 align-middle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Form Tambah Status Kepemilikan -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary"><i class="las la-plus-circle me-1"></i> Tambah Status Baru</h5>
                    <form action="{{ route('status-kantor.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Status <span class="text-danger">*</span></label>
                            <input type="text" name="nama_status" class="form-control @error('nama_status') is-invalid @enderror" value="{{ old('nama_status') }}" placeholder="Contoh: Rumah Sakit Daerah" required>
                            <small class="text-muted">Slug / Kode unik akan dibuat otomatis.</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="las la-save me-1"></i> Simpan Status
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Status Kepemilikan -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-primary"><i class="las la-list me-1"></i> Daftar Status Kepemilikan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th width="8%">No</th>
                                    <th>Nama Status</th>
                                    <th>Kode / Slug</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statusKantors as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item->nama_status }}</strong></td>
                                    <td><code>{{ $item->slug }}</code></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-warning me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="las la-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('status-kantor.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus status kepemilikan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="las la-trash"></i> Hapus
                                            </button>
                                        </form>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start">
                                                    <form action="{{ route('status-kantor.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Status Kepemilikan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Status <span class="text-danger">*</span></label>
                                                                <input type="text" name="nama_status" class="form-control" value="{{ old('nama_status', $item->nama_status) }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-warning">Perbarui</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="las la-building fs-3 d-block mb-2"></i>
                                        Belum ada data status kepemilikan.
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
</div>
@endsection
