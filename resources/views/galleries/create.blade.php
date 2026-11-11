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
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                <label class="form-label fw-bold text-dark mb-0" id="schedule_label">
                                    <i class="las la-clock text-primary"></i> Waktu Publikasi / Jadwal Tayang
                                </label>
                                <small class="text-muted" id="schedule_help">
                                    Pilih tanggal dan ketik jam tayang (format 24 jam). Jika status <strong>Terjadwal</strong>, dokumentasi otomatis terpublikasi saat waktu tiba.
                                </small>
                            </div>

                            @php
                                $selectedDate = old('publish_date', now()->format('Y-m-d'));
                                $selectedTime = old('publish_time', now()->format('H:i'));
                            @endphp

                            <div class="row g-2 align-items-end">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">
                                        <i class="las la-calendar text-primary"></i> Tanggal
                                    </label>
                                    <input
                                        type="date"
                                        name="publish_date"
                                        id="publish_date"
                                        class="form-control @error('publish_date') is-invalid @enderror"
                                        value="{{ $selectedDate }}"
                                        onchange="updateSchedulePreview()"
                                    >
                                    @error('publish_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label small fw-semibold text-secondary mb-0">
                                            <i class="las la-clock text-primary"></i> Jam (Ketik Manual 24 Jam)
                                        </label>
                                        <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none small text-primary" onclick="setCurrentTime()">
                                            <i class="las la-history"></i> Jam Sekarang
                                        </button>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white text-muted"><i class="las la-clock"></i></span>
                                        <input
                                            type="text"
                                            name="publish_time"
                                            id="publish_time"
                                            class="form-control @error('publish_time') is-invalid @enderror"
                                            placeholder="Contoh: 14:30"
                                            value="{{ $selectedTime }}"
                                            maxlength="5"
                                            oninput="updateSchedulePreview()"
                                        >
                                        <span class="input-group-text bg-light text-muted fw-semibold">WIB</span>
                                    </div>
                                    @error('publish_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">
                                        Ketik bebas format 24 jam (misal: <code>08:00</code>, <code>14:30</code>, <code>19:45</code>).
                                    </small>
                                </div>
                            </div>

                            <div class="mt-2 pt-2 border-top text-muted small d-flex align-items-center">
                                <i class="las la-info-circle text-info me-1 fs-6"></i>
                                <span>Waktu dipilih:&nbsp;</span>
                                <strong class="text-dark" id="schedule_preview_text">-</strong>
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

    function setCurrentTime() {
        const now = new Date();
        const pad = (n) => String(n).padStart(2, '0');
        const dateInput = document.getElementById('publish_date');
        const timeInput = document.getElementById('publish_time');

        if (dateInput) {
            dateInput.value = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())}`;
        }
        if (timeInput) {
            timeInput.value = `${pad(now.getHours())}:${pad(now.getMinutes())}`;
        }
        updateSchedulePreview();
    }

    function updateSchedulePreview() {
        const dateInput = document.getElementById('publish_date');
        const timeInput = document.getElementById('publish_time');
        const previewEl = document.getElementById('schedule_preview_text');

        if (!dateInput || !previewEl) return;

        const dateVal = dateInput.value;
        let timeVal = timeInput ? timeInput.value.trim().replace('.', ':') : '';
        if (!timeVal) timeVal = '08:00';

        if (dateVal) {
            const parts = dateVal.split('-');
            if (parts.length === 3) {
                const year = parts[0];
                const month = parseInt(parts[1], 10) - 1;
                const day = parseInt(parts[2], 10);
                const monthNames = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                const monthName = monthNames[month] || parts[1];
                previewEl.textContent = `${day} ${monthName} ${year} pukul ${timeVal} WIB`;
                return;
            }
        }
        previewEl.textContent = `${dateVal || '-'} pukul ${timeVal} WIB`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleMediaInputs();
        toggleScheduleInput();
        updateSchedulePreview();
    });
</script>
@endsection
