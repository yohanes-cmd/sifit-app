@extends('layouts.app')
@section('title', 'Ubah Dokumentasi Galeri - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Ubah Dokumentasi Galeri</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('galleries.index') }}">Galeri</a></li>
                            <li class="breadcrumb-item active">Ubah</li>
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
                    <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Dokumentasi Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipe Dokumentasi <span class="text-danger">*</span></label>
                                <select name="type" id="gallery_type" class="form-select @error('type') is-invalid @enderror" required onchange="toggleMediaInputs()">
                                    <option value="photo" {{ old('type', $gallery->type) == 'photo' ? 'selected' : '' }}>Foto / Gambar</option>
                                    <option value="video" {{ old('type', $gallery->type) == 'video' ? 'selected' : '' }}>Video Kegiatan</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status Publikasi <span class="text-danger">*</span></label>
                                @php
                                    $currentStatus = old('status', $gallery->status ?? ($gallery->is_active ? 'published' : 'draft'));
                                @endphp
                                <select name="status" id="gallery_status" class="form-select @error('status') is-invalid @enderror" required onchange="toggleScheduleInput()">
                                    <option value="published" {{ $currentStatus == 'published' ? 'selected' : '' }}>🟢 Publik (Langsung Tayang)</option>
                                    <option value="scheduled" {{ $currentStatus == 'scheduled' ? 'selected' : '' }}>🟡 Terjadwal (Tayang Otomatis Sesuai Waktu)</option>
                                    <option value="draft" {{ $currentStatus == 'draft' ? 'selected' : '' }}>⚪ Draf (Simpan Saja, Belum Tayang)</option>
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
                                $defaultDate = $gallery->published_at ? $gallery->published_at->format('Y-m-d') : now()->format('Y-m-d');
                                $defaultTime = $gallery->published_at ? $gallery->published_at->format('H:i') : now()->format('H:i');

                                $selectedDate = old('publish_date', $defaultDate);
                                $selectedTime = old('publish_time', $defaultTime);
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

                        {{-- PREVIEW MEDIA SEKARANG --}}
                        <div class="mb-3 p-3 bg-light rounded border">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold text-dark mb-0">Media Saat Ini:</label>
                                @if($gallery->type === 'video' && $gallery->youtube_url)
                                    <a href="{{ $gallery->youtube_url }}" target="_blank" class="small text-danger text-decoration-none fw-bold">
                                        <i class="lab la-youtube"></i> Buka di YouTube <i class="las la-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>

                            @if($gallery->type === 'photo')
                                <img src="{{ $gallery->media_url }}" alt="{{ $gallery->title }}" class="rounded border" style="max-height: 160px; object-fit: cover;">
                            @else
                                <div class="row align-items-center">
                                    <div class="col-md-5 mb-2 mb-md-0">
                                        @if($gallery->youtube_embed_url)
                                            <div class="ratio ratio-16x9 rounded overflow-hidden border">
                                                <iframe src="{{ $gallery->youtube_embed_url }}" title="{{ $gallery->title }}" allowfullscreen></iframe>
                                            </div>
                                        @elseif($gallery->file_path)
                                            <video controls style="width: 100%; max-height: 160px; border-radius: 8px;">
                                                <source src="{{ asset('storage/' . $gallery->file_path) }}">
                                            </video>
                                        @else
                                            <img src="{{ $gallery->media_url }}" alt="{{ $gallery->title }}" class="rounded border img-fluid">
                                        @endif
                                    </div>
                                    <div class="col-md-7">
                                        <small class="text-muted d-block mb-1">
                                            <strong>Tautan Video Saat Ini:</strong> {{ $gallery->youtube_url ?? 'Berkas video lokal' }}
                                        </small>
                                        <small class="text-muted d-block">
                                            Anda dapat memperbarui tautan YouTube di bawah dengan URL video yang aktif (misal video resmi Dinas Kesehatan atau Kemenkes RI).
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- FILE UPLOAD --}}
                        <div class="mb-3" id="file_input_wrapper">
                            <label class="form-label fw-bold" id="file_label">Ganti Berkas Media (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="file" name="media_file" class="form-control @error('media_file') is-invalid @enderror">
                            <small class="text-muted" id="file_hint">Maksimal ukuran berkas: 20 MB.</small>
                            @error('media_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- YOUTUBE URL --}}
                        <div class="mb-3" id="youtube_input_wrapper" style="display: none;">
                            <label class="form-label fw-bold text-danger"><i class="lab la-youtube"></i> Tautan Video YouTube</label>
                            <input type="url" name="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" value="{{ old('youtube_url', $gallery->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                            <small class="text-muted">Masukkan tautan video YouTube (misal: <code>https://www.youtube.com/watch?v=...</code>).</small>
                            @error('youtube_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan / Narasi Dokumentasi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $gallery->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-2 border-top">
                            <a href="{{ route('galleries.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="las la-save me-1"></i> Simpan Perubahan
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

        if (type === 'video') {
            ytWrap.style.display = 'block';
        } else {
            ytWrap.style.display = 'none';
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
