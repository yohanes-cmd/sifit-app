@extends('layouts.app')
@section('title', 'Daftar Program - SIFIT')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Program</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">Program</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('program.create') }}" class="btn btn-primary">
                            <i class="las la-plus me-1"></i> Tambah Program
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
                    <h5 class="fw-bold mb-3 text-primary">Daftar Program</h5>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Program</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programs as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code>{{ $item->kode }}</code></td>
                                    <td class="fw-semibold">{{ $item->nama }}</td>
                                    <td>{{ Str::limit($item->deskripsi, 60) ?: '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status == 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('program.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="las la-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('program.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data program ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="las la-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="las la-project-diagram fs-3 d-block mb-2"></i>
                                        Belum ada data program.
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
