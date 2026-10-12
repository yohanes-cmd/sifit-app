@extends('layouts.app')
@section('title', 'Edit Pengangkut - SIFIT')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Edit Pengangkut</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pengangkut.index') }}">Pengangkut</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="las la-edit me-2"></i>Edit Data Pengangkut</h5>
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

                    <form action="{{ route('pengangkut.update', $pengangkut->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama Pengangkut <span class="text-danger">*</span></label>
                            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama', $pengangkut->nama) }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label fw-semibold">Telepon</label>
                                <input type="text" id="telepon" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                    value="{{ old('telepon', $pengangkut->telepon) }}">
                                @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kendaraan" class="form-label fw-semibold">Jenis Kendaraan</label>
                                <input type="text" id="jenis_kendaraan" name="jenis_kendaraan" class="form-control @error('jenis_kendaraan') is-invalid @enderror"
                                    value="{{ old('jenis_kendaraan', $pengangkut->jenis_kendaraan) }}">
                                @error('jenis_kendaraan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label fw-semibold">Alamat</label>
                            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                rows="2">{{ old('alamat', $pengangkut->alamat) }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status', $pengangkut->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $pengangkut->status) == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="las la-save me-1"></i> Perbarui
                            </button>
                            <a href="{{ route('pengangkut.index') }}" class="btn btn-secondary">
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
