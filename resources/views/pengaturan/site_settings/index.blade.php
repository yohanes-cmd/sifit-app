@extends('layouts.app')
@section('title', 'Kelola Konten Tentang SIFIT & Kontak - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Kelola Konten Tentang SIFIT & Informasi Publik</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">Konten SIFIT</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="las la-check-circle me-1 fs-5 align-middle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="las la-exclamation-circle me-1 fs-5 align-middle"></i>
            <strong>Gagal menyimpan!</strong> Harap periksa kolom isian yang belum lengkap atau tidak valid.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <form action="{{ route('site-settings.update') }}" method="POST" id="siteSettingsForm" novalidate>
            @csrf
            @method('PUT')

            <input type="hidden" name="active_tab" id="active_tab_input" value="{{ old('active_tab', 'profil') }}">

            <div class="card-header bg-white border-bottom">
                <ul class="nav nav-tabs card-header-tabs" id="settingTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="profil-tab" data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab" onclick="document.getElementById('active_tab_input').value='profil'">
                            <i class="las la-info-circle me-1"></i> Profil & Beranda
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="visimisi-tab" data-bs-toggle="tab" data-bs-target="#visimisi" type="button" role="tab" onclick="document.getElementById('active_tab_input').value='visimisi'">
                            <i class="las la-bullseye me-1"></i> Visi & Misi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="tujuan-tab" data-bs-toggle="tab" data-bs-target="#tujuan" type="button" role="tab" onclick="document.getElementById('active_tab_input').value='tujuan'">
                            <i class="las la-star me-1"></i> Nilai & Sasaran Layanan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-semibold" id="kontak-tab" data-bs-toggle="tab" data-bs-target="#kontak" type="button" role="tab" onclick="document.getElementById('active_tab_input').value='kontak'">
                            <i class="las la-phone me-1"></i> Kontak & Jam Layanan
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="settingTabsContent">

                    {{-- TAB 1: PROFIL & TENTANG SIFIT --}}
                    <div class="tab-pane fade show active" id="profil" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Ringkasan Sambutan Beranda (Hero)</label>
                            <textarea name="beranda_hero_ringkasan" class="form-control" rows="3">{{ old('beranda_hero_ringkasan', $settings['beranda_hero_ringkasan'] ?? '') }}</textarea>
                            <small class="text-muted">Teks pengantar ringkas dan padat khusus untuk banner halaman Beranda depan (1-2 kalimat).</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Judul Halaman Tentang Kami</label>
                            <input type="text" name="tentang_judul" class="form-control" value="{{ old('tentang_judul', $settings['tentang_judul'] ?? '') }}" required>
                            <small class="text-muted">Ditampilkan sebagai judul utama pada halaman Tentang Kami.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">Nama Instansi Pengelola</label>
                                <input type="text" name="tentang_instansi" class="form-control" value="{{ old('tentang_instansi', $settings['tentang_instansi'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">Tagline / Sub-label</label>
                                <input type="text" name="tentang_tagline" class="form-control" value="{{ old('tentang_tagline', $settings['tentang_tagline'] ?? '') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Motto Pelayanan</label>
                            <input type="text" name="tentang_motto" class="form-control" value="{{ old('tentang_motto', $settings['tentang_motto'] ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Deskripsi Lengkap Tentang SIFIT (Khusus Halaman Tentang Kami)</label>
                            <textarea name="tentang_deskripsi" class="form-control" rows="8" required>{{ old('tentang_deskripsi', $settings['tentang_deskripsi'] ?? '') }}</textarea>
                            <small class="text-muted">Narasi profil mendalam, dasar hukum, dan fungsi UPT Instalasi Farmasi (tampil di halaman Tentang Kami).</small>
                        </div>
                    </div>

                    {{-- TAB 2: VISI & MISI --}}
                    <div class="tab-pane fade" id="visimisi" role="tabpanel">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Visi SIFIT Riau</label>
                            <textarea name="visi_sifit" class="form-control" rows="4" required>{{ old('visi_sifit', $settings['visi_sifit'] ?? '') }}</textarea>
                            <small class="text-muted">Pernyataan visi utama pelayanan informasi kefarmasian SIFIT.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Misi SIFIT Riau</label>
                            <textarea name="misi_sifit" class="form-control" rows="6" required>{{ old('misi_sifit', $settings['misi_sifit'] ?? '') }}</textarea>
                            <small class="text-muted">Tuliskan tiap poin misi pada baris baru (tekan Enter untuk baris baru). Sistem otomatis menampilkannya sebagai daftar poin berurutan.</small>
                        </div>
                    </div>

                    {{-- TAB 3: NILAI & SASARAN LAYANAN --}}
                    <div class="tab-pane fade" id="tujuan" role="tabpanel">
                        <p class="text-muted mb-4">Kelola 3 pilar nilai sasaran strategis yang tampil pada halaman Tentang Kami dan Beranda.</p>

                        {{-- Pilar 1 --}}
                        <div class="border rounded p-3 mb-3 bg-light">
                            <h6 class="fw-bold text-primary mb-2"><i class="las la-check-circle me-1"></i> Sasaran Layanan 1</h6>
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Judul Sasaran 1</label>
                                <input type="text" name="tujuan_1_judul" class="form-control" value="{{ old('tujuan_1_judul', $settings['tujuan_1_judul'] ?? '') }}" required>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Uraian Sasaran 1</label>
                                <textarea name="tujuan_1_isi" class="form-control" rows="2" required>{{ old('tujuan_1_isi', $settings['tujuan_1_isi'] ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Pilar 2 --}}
                        <div class="border rounded p-3 mb-3 bg-light">
                            <h6 class="fw-bold text-primary mb-2"><i class="las la-check-circle me-1"></i> Sasaran Layanan 2</h6>
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Judul Sasaran 2</label>
                                <input type="text" name="tujuan_2_judul" class="form-control" value="{{ old('tujuan_2_judul', $settings['tujuan_2_judul'] ?? '') }}" required>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Uraian Sasaran 2</label>
                                <textarea name="tujuan_2_isi" class="form-control" rows="2" required>{{ old('tujuan_2_isi', $settings['tujuan_2_isi'] ?? '') }}</textarea>
                            </div>
                        </div>

                        {{-- Pilar 3 --}}
                        <div class="border rounded p-3 mb-3 bg-light">
                            <h6 class="fw-bold text-primary mb-2"><i class="las la-check-circle me-1"></i> Sasaran Layanan 3</h6>
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Judul Sasaran 3</label>
                                <input type="text" name="tujuan_3_judul" class="form-control" value="{{ old('tujuan_3_judul', $settings['tujuan_3_judul'] ?? '') }}" required>
                            </div>
                            <div>
                                <label class="form-label fw-semibold">Uraian Sasaran 3</label>
                                <textarea name="tujuan_3_isi" class="form-control" rows="2" required>{{ old('tujuan_3_isi', $settings['tujuan_3_isi'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- TAB 4: KONTAK & JAM LAYANAN --}}
                    <div class="tab-pane fade" id="kontak" role="tabpanel">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Alamat Kantor Lengkap</label>
                            <textarea name="kontak_alamat" class="form-control" rows="2" required>{{ old('kontak_alamat', $settings['kontak_alamat'] ?? '') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">Nomor Telepon / Call Center</label>
                                <input type="text" name="kontak_telepon" class="form-control" value="{{ old('kontak_telepon', $settings['kontak_telepon'] ?? '') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-dark">Alamat Email Resmi</label>
                                <input type="email" name="kontak_email" class="form-control" value="{{ old('kontak_email', $settings['kontak_email'] ?? '') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Jam Layanan Operasional</label>
                            <input type="text" name="kontak_jam_layanan" class="form-control" value="{{ old('kontak_jam_layanan', $settings['kontak_jam_layanan'] ?? '') }}" required>
                            <small class="text-muted">Contoh: Senin - Jumat: 08:00 - 16:00 WIB</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">URL Embed Google Maps</label>
                            <input type="text" name="kontak_maps_embed" class="form-control" value="{{ old('kontak_maps_embed', $settings['kontak_maps_embed'] ?? '') }}">
                            <small class="text-muted">Masukkan link `https://www.google.com/maps/embed?...` untuk peta interaktif di halaman Kontak.</small>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer bg-light border-top d-flex justify-content-between align-items-center">
                <span class="text-muted small"><i class="las la-info-circle"></i> Seluruh kolom di atas tersimpan otomatis ke database saat Anda menekan tombol simpan.</span>
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="las la-save me-1"></i> Simpan Perubahan Konten
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const activeTab = "{{ session('active_tab', old('active_tab', 'profil')) }}";
        const triggerEl = document.getElementById(activeTab + '-tab');
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        } else {
            const firstTab = document.getElementById('profil-tab');
            if (firstTab) {
                const tab = new bootstrap.Tab(firstTab);
                tab.show();
            }
        }
    });
</script>
@endpush
@endsection
