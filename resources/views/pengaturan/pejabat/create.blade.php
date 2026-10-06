@extends('layouts.app')
@section('title', 'Tambah Pejabat - SIFIT')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tambah Pejabat</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pejabat.index') }}">Setting Pejabat</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="las la-user-tie me-2"></i>Form Tambah Pejabat</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pejabat.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Pejabat <span class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" placeholder="Masukkan nama pejabat" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="jabatan" class="form-label fw-semibold">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                                value="{{ old('jabatan') }}" placeholder="Contoh: Kepala Dinas" required>
                            @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label fw-semibold">NIP</label>
                                <input type="text" id="nip" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                    value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai">
                                @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="periode" class="form-label fw-semibold">Periode</label>
                                <input type="text" id="periode" name="periode" class="form-control @error('periode') is-invalid @enderror"
                                    value="{{ old('periode') }}" placeholder="Contoh: 2023 - 2025">
                                @error('periode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="las la-save me-1"></i> Simpan
                            </button>
                            <a href="{{ route('pejabat.index') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
