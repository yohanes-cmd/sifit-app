@extends('layouts.app')
@section('title', 'Tambah Dokumentasi Galeri - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tambah Dokumentasi Galeri (Foto / Video)</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('galleries.index') }}">Galeri</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-9 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Dokumentasi Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Monitoring dan Evaluasi Cold Chain Instalasi Farmasi" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Dokumentasi <span class="text-danger">*</span></label>
                                <select name="type" id="gallery_type" class="form-select @error('type') is-invalid @enderror" required onchange="toggleMediaInputs()">
                                    <option value="photo" {{ old('type') == 'photo' ? 'selected' : '' }}>Foto / Gambar</option>
                                    <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video Kegiatan</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status Publikasi <span class="text-danger">*</span></label>
                                <select name="status" id="gallery_status" class="form-select @error('status') is-invalid @enderror" required onchange="toggleScheduleInput()">
                                    <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>🟢 Publik (Langsung Tayang)</option>
                                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>🟡 Terjadwal (Tayang Otomatis Sesuai Waktu)</option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>⚪ Draf (Simpan Saja, Belum Tayang)</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- WAKTU PUBLIKASI / JADWAL TAYANG --}}
                        <div class="mb-3 p-3 rounded border bg-light" id="schedule_wrapper">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark mb-1" id="schedule_label">
                                        <i class="las la-clock text-primary"></i> Waktu Publikasi / Jadwal Tayang
                                    </label>
                                    <input
                                        type="datetime-local"
                                        name="published_at"
                                        id="published_at"
                                        class="form-control @error('published_at') is-invalid @enderror"
                                        value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                    >
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mt-2 mt-md-0">
                                    <small class="text-muted d-block" id="schedule_help">
                                        Pilih tanggal dan jam. Jika status <strong>Terjadwal</strong>, dokumentasi akan <em>otomatis terpublikasi ke publik</em> saat waktu yang ditentukan telah tiba.
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- FILE UPLOAD (FOTO / VIDEO MP4) --}}
                        <div class="mb-3" id="file_input_wrapper">
                            <label class="form-label fw-bold" id="file_label">Unggah Berkas Gambar (JPG, PNG, WebP) / Video (MP4)</label>
                            <input type="file" name="media_file" class="form-control @error('media_file') is-invalid @enderror">
                            <small class="text-muted" id="file_hint">Maksimal ukuran berkas: 20 MB.</small>
                            @error('media_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- YOUTUBE URL (OPSIONAL UNTUK VIDEO) --}}
                        <div class="mb-3" id="youtube_input_wrapper" style="display: none;">
                            <label class="form-label fw-bold text-danger"><i class="lab la-youtube"></i> Tautan Video YouTube (Alternatif / Disarankan)</label>
                            <input type="url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                            <small class="text-muted">Jika video berada di YouTube, tempel tautan video di sini. Sistem akan menampilkan pemutar YouTube secara otomatis.</small>
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan / Narasi Dokumentasi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Jelaskan mengenai agenda kegiatan, tanggal pelaksanaan, lokasi, atau pesan edukasi kefarmasian...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                            <a href="{{ route('galleries.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="las la-save me-1"></i> Simpan Dokumentasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleMediaInputs() {
        const type = document.getElementById('gallery_type').value;
        const ytWrap = document.getElementById('youtube_input_wrapper');
        const fileLabel = document.getElementById('file_label');
        const fileHint = document.getElementById('file_hint');

        if (type === 'video') {
            ytWrap.style.display = 'block';
            fileLabel.innerHTML = 'Unggah Berkas Video MP4 (Opsional jika pakai YouTube)';
            fileHint.innerHTML = 'Format: MP4, MOV. Maksimal 20 MB. Atau gunakan tautan YouTube di bawah.';
        } else {
            ytWrap.style.display = 'none';
            fileLabel.innerHTML = 'Unggah Berkas Foto (JPG, PNG, WebP) <span class="text-danger">*</span>';
            fileHint.innerHTML = 'Format: JPG, JPEG, PNG, WebP. Maksimal 10 MB.';
        }
    }

    function toggleScheduleInput() {
        const status = document.getElementById('gallery_status').value;
        const wrapper = document.getElementById('schedule_wrapper');
        const label = document.getElementById('schedule_label');
        const help = document.getElementById('schedule_help');

        if (status === 'scheduled') {
            wrapper.className = 'mb-3 p-3 rounded border border-warning bg-warning bg-opacity-10';
            label.innerHTML = '<i class="las la-calendar-check text-warning fs-5"></i> Jadwal Tayang Otomatis <span class="text-danger">*</span>';
            help.innerHTML = '<span class="badge bg-warning text-dark me-1">Terjadwal</span> Dokumentasi akan <strong>otomatis tayang di publik</strong> tepat saat waktu di samping tiba.';
        } else if (status === 'draft') {
            wrapper.className = 'mb-3 p-3 rounded border bg-light opacity-75';
            label.innerHTML = '<i class="las la-file-alt text-secondary"></i> Waktu Penyimpanan Draf';
            help.innerHTML = '<span class="badge bg-secondary me-1">Draf</span> Dokumen tersimpan sebagai arsip internal dan belum terlihat oleh pengunjung website publik.';
        } else {
            wrapper.className = 'mb-3 p-3 rounded border bg-light';
            label.innerHTML = '<i class="las la-globe text-success"></i> Waktu Publikasi';
            help.innerHTML = '<span class="badge bg-success me-1">Publik</span> Dokumentasi langsung dapat dilihat oleh publik saat ini.';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleMediaInputs();
        toggleScheduleInput();
    });
</script>
@endsection
