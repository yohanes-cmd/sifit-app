@extends('layouts.app')
@section('title', 'Tambah Pertanyaan FAQ - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tambah Pertanyaan FAQ</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">FAQ</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('faq.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pertanyaan <span class="text-danger">*</span></label>
                            <input type="text" name="question" class="form-control @error('question') is-invalid @enderror" value="{{ old('question') }}" placeholder="Contoh: Apa itu SIFIT Provinsi Riau?" required>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jawaban <span class="text-danger">*</span></label>
                            <textarea name="answer" class="form-control @error('answer') is-invalid @enderror" rows="5" placeholder="Tuliskan jawaban lengkap yang jelas dan informatif..." required>{{ old('answer') }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nomor Urutan Tampil</label>
                                <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                                <small class="text-muted">Urutan tampil di halaman publik (angka lebih kecil tampil lebih atas).</small>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">
                                        Publikasikan (Aktif)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('faq.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
