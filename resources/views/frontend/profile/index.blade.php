@extends('frontend.layouts.app')
@section('title', 'Profil Pengguna - SIFIT Farmasi Riau')

@section('content')
<style>
    /* ==========================================================================
       SIFIT PREMIUM PROFILE PAGE STYLES
       ========================================================================== */
    .sifit-profile-wrapper {
        background-color: #f8fafc;
        padding: 40px 0 70px;
        min-height: calc(100vh - 460px);
    }

    /* BREADCRUMB BANNER */
    .sifit-profile-banner {
        background: linear-gradient(135deg, #07252c 0%, #0b3a46 45%, #115566 100%);
        padding: 28px 0;
        border-bottom: 3px solid var(--sifit-accent, #4db6ac);
        color: #ffffff;
        position: relative;
    }

    .sifit-profile-banner h1 {
        font-size: 24px;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 6px 0;
        display: flex;
        align-items: center;
        gap: 10px;
        letter-spacing: -0.3px;
    }

    .sifit-profile-banner p {
        font-size: 13.5px;
        color: rgba(255, 255, 255, 0.85);
        margin: 0;
    }

    .sifit-banner-breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 6px 16px;
        border-radius: 30px;
        list-style: none;
        margin: 0;
    }

    .sifit-banner-breadcrumb li {
        font-size: 12.5px;
        color: rgba(255, 255, 255, 0.8);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .sifit-banner-breadcrumb li a {
        color: #ffffff;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .sifit-banner-breadcrumb li a:hover {
        color: #4db6ac;
    }

    .sifit-banner-breadcrumb li.active {
        color: #4db6ac;
        font-weight: 700;
    }

    /* GRID EQUAL HEIGHT SYSTEM */
    @media (min-width: 992px) {
        .sifit-profile-row {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: stretch !important;
        }

        .sifit-profile-row::before,
        .sifit-profile-row::after {
            display: none !important;
            content: none !important;
        }

        .sifit-profile-row > [class*="col-"] {
            display: flex !important;
            flex-direction: column !important;
        }

        .sifit-profile-row .sifit-card {
            height: 100% !important;
            margin-bottom: 0 !important;
        }
    }

    @media (max-width: 991px) {
        .sifit-profile-row .sifit-card {
            margin-bottom: 24px;
        }
    }

    /* CARDS COMMON */
    .sifit-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(17, 85, 102, 0.05);
        overflow: hidden;
        margin-bottom: 25px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
    }

    /* LEFT PROFILE CARD */
    .profile-card-cover {
        height: 95px;
        background: linear-gradient(135deg, #0b3a46 0%, #115566 60%, #4db6ac 100%);
        position: relative;
        flex-shrink: 0;
    }

    .profile-card-cover::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px);
        background-size: 12px 12px;
        opacity: 0.6;
    }

    .profile-card-body {
        padding: 0 24px 24px;
        text-align: center;
        position: relative;
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
    }

    .profile-avatar-box {
        position: relative;
        display: inline-block;
        margin-top: -50px;
        margin-bottom: 14px;
        z-index: 2;
    }

    .profile-avatar-img {
        width: 105px;
        height: 105px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #ffffff;
        box-shadow: 0 8px 20px rgba(17, 85, 102, 0.2);
        background: #ffffff;
        display: block;
    }

    .profile-avatar-badge {
        position: absolute;
        bottom: 4px;
        right: 4px;
        width: 20px;
        height: 20px;
        background: #10b981;
        border: 3px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .profile-name {
        font-size: 19px;
        font-weight: 800;
        color: #0f172a;
        margin: 0 0 3px 0;
        letter-spacing: -0.3px;
    }

    .profile-email {
        font-size: 13px;
        color: #64748b;
        margin: 0 0 12px 0;
    }

    .profile-badge-row {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 20px;
    }

    .badge-opd {
        background: #e6f4f2;
        color: #115566;
        border: 1px solid rgba(77, 182, 172, 0.4);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-verified {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* INFO TILES */
    .profile-info-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        text-align: left;
        margin-bottom: 22px;
    }

    .info-tile {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 11px 14px;
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 12px;
        transition: background 0.2s ease, border-color 0.2s ease;
    }

    .info-tile:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
    }

    .info-tile-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .info-tile-icon.blue { background: #eff6ff; color: #2563eb; }
    .info-tile-icon.emerald { background: #ecfdf5; color: #059669; }
    .info-tile-icon.teal { background: #e6f4f2; color: #115566; }
    .info-tile-icon.amber { background: #fffbeb; color: #d97706; }

    .info-tile-meta {
        overflow: hidden;
    }

    .info-tile-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        display: block;
        line-height: 1.2;
    }

    .info-tile-value {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        display: block;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* LEFT CARD FOOTER */
    .profile-card-footer {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        width: 100%;
        display: flex;
        align-items: center;
    }

    .btn-profile-signout {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        height: 44px;
        box-sizing: border-box;
        background: #ffffff;
        border: 1.5px solid #fee2e2;
        color: #dc2626;
        padding: 0 16px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-profile-signout:hover {
        background: #fee2e2;
        border-color: #fca5a5;
        color: #b91c1c;
        transform: translateY(-1px);
    }

    /* RIGHT SETTINGS CARD */
    .profile-settings-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
    }

    /* SEGMENTED CONTROL TABS */
    .sifit-segmented-tabs {
        display: inline-flex;
        background: #f1f5f9;
        padding: 5px;
        border-radius: 12px;
        gap: 6px;
        margin-bottom: 24px;
        width: 100%;
        border: 1px solid #e2e8f0;
        flex-shrink: 0;
    }

    .sifit-seg-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border: none;
        background: transparent;
        color: #64748b;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .sifit-seg-btn:hover {
        color: #115566;
    }

    .sifit-seg-btn.active {
        background: #ffffff;
        color: #115566;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .sifit-tab-view {
        display: none;
        animation: sifitFadeIn 0.2s ease-out;
    }

    .sifit-tab-view.active {
        display: flex !important;
        flex-direction: column !important;
        flex: 1 1 auto !important;
    }

    .sifit-tab-view.active > form {
        display: flex !important;
        flex-direction: column !important;
        flex: 1 1 auto !important;
    }

    @keyframes sifitFadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* AVATAR UPLOAD CARD */
    .avatar-uploader-card {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 18px 22px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        margin-bottom: 24px;
    }

    .avatar-uploader-preview {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #115566;
        box-shadow: 0 4px 12px rgba(17, 85, 102, 0.15);
        flex-shrink: 0;
    }

    .btn-choose-file {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ffffff;
        border: 1.5px solid #115566;
        color: #115566;
        padding: 7px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: 4px;
    }

    .btn-choose-file:hover {
        background: #115566;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(17, 85, 102, 0.25);
    }

    /* SECTION HEADER */
    .form-section-title {
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #115566;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    /* FORM GROUPS */
    .sifit-form-box {
        margin-bottom: 18px;
    }

    .sifit-field-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 7px;
    }

    .sifit-field-label span.req {
        color: #ef4444;
    }

    .sifit-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .sifit-input-container .input-ico {
        position: absolute;
        left: 14px;
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    .sifit-text-input {
        width: 100%;
        padding: 11px 14px 11px 40px;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        font-size: 13.5px;
        color: #0f172a;
        background: #ffffff;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .sifit-text-input:focus {
        border-color: #115566;
        outline: none;
        box-shadow: 0 0 0 3px rgba(17, 85, 102, 0.15);
    }

    .sifit-text-input.readonly-style {
        background: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
        cursor: not-allowed;
    }

    .sifit-toggle-eye {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        font-size: 14px;
        transition: color 0.15s ease;
    }

    .sifit-toggle-eye:hover {
        color: #334155;
    }

    /* ACTION BUTTON */
    .sifit-action-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        width: 100%;
    }

    .sifit-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 44px;
        box-sizing: border-box;
        background: linear-gradient(135deg, #115566 0%, #0d4452 60%, #16697a 100%);
        border: none;
        color: #ffffff;
        padding: 0 26px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.25);
    }

    .sifit-btn-primary:hover {
        background: linear-gradient(135deg, #0b3a46 0%, #082931 60%, #115566 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(17, 85, 102, 0.35);
    }

    /* NOTICE BOX */
    .sifit-notice-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 12.5px;
        color: #1e40af;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    /* ALERTS */
    .sifit-alert {
        padding: 12px 18px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .sifit-alert.success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }

    .sifit-alert.danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }
</style>

{{-- BREADCRUMB HERO BANNER RESMI --}}
<section class="sifit-profile-banner">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
            <div>
                <h1><i class="fa fa-user-circle" style="color: #4db6ac;"></i> Profil Pengguna</h1>
                <p>Pusat pengelolaan akun terdaftar, data instansi, dan keamanan login SIFIT</p>
            </div>
            <div>
                <ul class="sifit-banner-breadcrumb">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Profil Saya</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- PROFILE CONTENT AREA --}}
<section class="sifit-profile-wrapper">
    <div class="container">

        {{-- Flash Notification --}}
        @if(session('success'))
            <div class="sifit-alert success">
                <i class="fa fa-check-circle" style="font-size: 18px;"></i>
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="sifit-alert danger">
                <i class="fa fa-exclamation-triangle" style="font-size: 18px;"></i>
                <div>
                    <strong>Terjadi kendala:</strong>
                    <ul style="margin: 4px 0 0 16px; padding: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="row sifit-profile-row">
            
            {{-- KOLOM KIRI: KARTU SUMMARY PROFIL (MODERN) --}}
            <div class="col-lg-4 col-md-5 col-sm-12">
                <div class="sifit-card">
                    {{-- Decorative Top Cover --}}
                    <div class="profile-card-cover"></div>

                    {{-- Profile Card Body --}}
                    <div class="profile-card-body">
                        <div class="profile-avatar-box">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar-img" id="avatarSummaryImg">
                            <span class="profile-avatar-badge" title="Akun Aktif Terverifikasi"></span>
                        </div>

                        <h2 class="profile-name">{{ $user->name }}</h2>
                        <p class="profile-email">{{ $user->email }}</p>

                        <div class="profile-badge-row">
                            @if($user->opd)
                                <span class="badge-opd" title="Unit Kerja Resmi">
                                    <i class="fa fa-building"></i> {{ $user->opd }}
                                </span>
                            @endif
                            <span class="badge-verified">
                                <i class="fa fa-check-circle"></i> Terverifikasi
                            </span>
                        </div>

                        {{-- Info Tiles List --}}
                        <div class="profile-info-list">
                            <div class="info-tile">
                                <div class="info-tile-icon blue"><i class="fa fa-envelope"></i></div>
                                <div class="info-tile-meta">
                                    <span class="info-tile-label">Alamat Email</span>
                                    <span class="info-tile-value" title="{{ $user->email }}">{{ $user->email }}</span>
                                </div>
                            </div>

                            <div class="info-tile">
                                <div class="info-tile-icon emerald"><i class="fa fa-phone"></i></div>
                                <div class="info-tile-meta">
                                    <span class="info-tile-label">Nomor Telepon / WA</span>
                                    <span class="info-tile-value">{{ $user->phone ?: 'Belum ditambahkan' }}</span>
                                </div>
                            </div>

                            <div class="info-tile">
                                <div class="info-tile-icon teal"><i class="fa fa-building"></i></div>
                                <div class="info-tile-meta">
                                    <span class="info-tile-label">Instansi / Unit Kerja</span>
                                    <span class="info-tile-value">{{ $user->opd ?: 'Pengguna Terdaftar' }}</span>
                                </div>
                            </div>

                            <div class="info-tile">
                                <div class="info-tile-icon amber"><i class="fa fa-calendar-check-o"></i></div>
                                <div class="info-tile-meta">
                                    <span class="info-tile-label">Terdaftar Sejak</span>
                                    <span class="info-tile-value">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Logout Action --}}
                        <div class="profile-card-footer">
                            <a href="#" class="btn-profile-signout" onclick="event.preventDefault(); document.getElementById('form-logout-frontend').submit();">
                                <i class="fa fa-power-off"></i> Keluar dari Akun
                            </a>
                            <form id="form-logout-frontend" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="from" value="frontend">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORMULIR EDIT & KEAMANAN --}}
            <div class="col-lg-8 col-md-7 col-sm-12">
                <div class="sifit-card">
                    <div class="profile-settings-body">

                        {{-- Segmented Tabs --}}
                        <div class="sifit-segmented-tabs">
                            <button type="button" class="sifit-seg-btn {{ !$errors->has('current_password') && !$errors->has('password') ? 'active' : '' }}" onclick="switchTab('tab-profile-info', this)">
                                <i class="fa fa-user"></i> Informasi Profil
                            </button>
                            <button type="button" class="sifit-seg-btn {{ $errors->has('current_password') || $errors->has('password') ? 'active' : '' }}" onclick="switchTab('tab-profile-password', this)">
                                <i class="fa fa-shield"></i> Keamanan & Kata Sandi
                            </button>
                        </div>

                        {{-- TAB 1: INFORMASI PROFIL --}}
                        <div id="tab-profile-info" class="sifit-tab-view {{ !$errors->has('current_password') && !$errors->has('password') ? 'active' : '' }}">
                            <form action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Avatar Uploader Card --}}
                                <div class="avatar-uploader-card">
                                    <img src="{{ $user->avatar_url }}" alt="Preview Avatar" id="avatarUploaderPreview" class="avatar-uploader-preview">
                                    <div>
                                        <label class="btn-choose-file" for="avatarInputField">
                                            <i class="fa fa-camera"></i> Unggah Foto Baru
                                        </label>
                                        <input type="file" id="avatarInputField" name="avatar" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/webp">
                                        <div style="font-size: 11.5px; color: #64748b; margin-top: 2px;">Format didukung: JPG, PNG, WEBP (Maksimal 2MB).</div>
                                        @error('avatar')
                                            <div style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-section-title">Data Pengguna</div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="sifit-form-box">
                                            <label for="name" class="sifit-field-label">Nama Lengkap <span class="req">*</span></label>
                                            <div class="sifit-input-container">
                                                <i class="fa fa-user input-ico"></i>
                                                <input type="text" id="name" name="name" class="sifit-text-input" value="{{ old('name', $user->name) }}" required>
                                            </div>
                                            @error('name')
                                                <div style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="sifit-form-box">
                                            <label for="email" class="sifit-field-label">Alamat Email <span class="req">*</span></label>
                                            <div class="sifit-input-container">
                                                <i class="fa fa-envelope input-ico"></i>
                                                <input type="email" id="email" name="email" class="sifit-text-input" value="{{ old('email', $user->email) }}" required>
                                            </div>
                                            @error('email')
                                                <div style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-title" style="margin-top: 8px;">Kontak & Instansi</div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="sifit-form-box">
                                            <label for="phone" class="sifit-field-label">Nomor Telepon / WhatsApp</label>
                                            <div class="sifit-input-container">
                                                <i class="fa fa-phone input-ico"></i>
                                                <input type="text" id="phone" name="phone" class="sifit-text-input" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                                            </div>
                                            @error('phone')
                                                <div style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="sifit-form-box">
                                            <label for="opd" class="sifit-field-label">Instansi / Unit Kerja</label>
                                            <div class="sifit-input-container">
                                                <i class="fa fa-building input-ico"></i>
                                                <input type="text" id="opd" class="sifit-text-input readonly-style" value="{{ $user->opd ?: 'Pengguna Umum' }}" readonly>
                                            </div>
                                            <div style="font-size: 11px; color: #94a3b8; margin-top: 4px;">
                                                <i class="fa fa-lock" style="font-size: 10px;"></i> Ditetapkan resmi oleh administrator.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sifit-action-footer">
                                    <button type="submit" class="sifit-btn-primary">
                                        <i class="fa fa-check-circle"></i> Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- TAB 2: KEAMANAN KATA SANDI --}}
                        <div id="tab-profile-password" class="sifit-tab-view {{ $errors->has('current_password') || $errors->has('password') ? 'active' : '' }}">
                            <form action="{{ route('frontend.profile.update-password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="sifit-notice-box">
                                    <i class="fa fa-info-circle" style="font-size: 16px; flex-shrink: 0;"></i>
                                    <span>Gunakan kombinasi minimal 8 karakter dengan huruf kapital, huruf kecil, dan angka untuk menjaga keamanan akun Anda.</span>
                                </div>

                                <div class="sifit-form-box">
                                    <label for="current_password" class="sifit-field-label">Kata Sandi Saat Ini <span class="req">*</span></label>
                                    <div class="sifit-input-container">
                                        <i class="fa fa-key input-ico"></i>
                                        <input type="password" id="current_password" name="current_password" class="sifit-text-input" style="padding-right: 42px;" required placeholder="Masukkan kata sandi lama">
                                        <button type="button" class="sifit-toggle-eye" onclick="togglePasswordEye('current_password', this)">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <div style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="sifit-form-box">
                                            <label for="password" class="sifit-field-label">Kata Sandi Baru <span class="req">*</span></label>
                                            <div class="sifit-input-container">
                                                <i class="fa fa-lock input-ico"></i>
                                                <input type="password" id="password" name="password" class="sifit-text-input" style="padding-right: 42px;" required placeholder="Minimal 8 karakter">
                                                <button type="button" class="sifit-toggle-eye" onclick="togglePasswordEye('password', this)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div style="color: #ef4444; font-size: 11.5px; margin-top: 4px;">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="sifit-form-box">
                                            <label for="password_confirmation" class="sifit-field-label">Konfirmasi Kata Sandi Baru <span class="req">*</span></label>
                                            <div class="sifit-input-container">
                                                <i class="fa fa-shield input-ico"></i>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="sifit-text-input" style="padding-right: 42px;" required placeholder="Ulangi kata sandi baru">
                                                <button type="button" class="sifit-toggle-eye" onclick="togglePasswordEye('password_confirmation', this)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sifit-action-footer">
                                    <button type="submit" class="sifit-btn-primary">
                                        <i class="fa fa-shield"></i> Perbarui Kata Sandi
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

@push('scripts')
<script>
    // Tab Switcher
    function switchTab(viewId, triggerBtn) {
        document.querySelectorAll('.sifit-seg-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.sifit-tab-view').forEach(view => view.classList.remove('active'));

        triggerBtn.classList.add('active');
        const targetView = document.getElementById(viewId);
        if (targetView) {
            targetView.classList.add('active');
        }
    }

    // Toggle Password Visibility
    function togglePasswordEye(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Live Avatar Preview
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatarInputField');
        const previewUploader = document.getElementById('avatarUploaderPreview');
        const previewSummary = document.getElementById('avatarSummaryImg');

        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        if (previewUploader) previewUploader.src = event.target.result;
                        if (previewSummary) previewSummary.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush
@endsection
