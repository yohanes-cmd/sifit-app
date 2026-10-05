<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Profil Pengguna - SIFIT Farmasi Riau</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Profil Pengguna SIFIT" name="description" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-riau.png') }}">

    {{-- Fonts & CSS Frameworks --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        :root {
            --sifit-primary: #115566;
            --sifit-primary-dark: #0d4452;
            --sifit-accent: #4db6ac;
            --sifit-accent-soft: rgba(77, 182, 172, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7f9;
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }

        /* Top Minimal Header */
        .profile-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 0;
            box-shadow: 0 2px 8px rgba(17, 85, 102, 0.04);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand-logo-img {
            height: 42px;
            width: auto;
        }

        .btn-sifit-back {
            background: #f8fafc;
            border: 1.5px solid #cbd5e1;
            color: #334155;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-sifit-back:hover {
            background: var(--sifit-primary);
            border-color: var(--sifit-primary);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-sifit-logout {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #b91c1c;
            padding: 7px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-sifit-logout:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
        }

        .btn-sifit-admin {
            background: rgba(17, 85, 102, 0.1);
            border: 1px solid rgba(17, 85, 102, 0.25);
            color: var(--sifit-primary);
            padding: 7px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-sifit-admin:hover {
            background: var(--sifit-primary);
            color: #ffffff;
        }

        /* Profile Main Layout */
        .profile-main-content {
            flex: 1;
            padding: 35px 0 50px;
        }

        .page-title-header {
            margin-bottom: 25px;
        }

        .page-title-header h3 {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .breadcrumb-custom {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #64748b;
        }

        .breadcrumb-custom a {
            color: var(--sifit-primary);
            text-decoration: none;
            font-weight: 600;
        }

        .breadcrumb-custom a:hover {
            text-decoration: underline;
        }

        /* Cards */
        .card-custom {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 25px;
            overflow: hidden;
        }

        /* Left User Summary Card */
        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
            margin: 0 auto;
        }

        .profile-avatar-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 6px 18px rgba(17, 85, 102, 0.15);
            transition: transform 0.25s ease;
        }

        .profile-avatar-badge {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background: #22c55e;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid #ffffff;
        }

        .badge-role-sifit {
            background: rgba(17, 85, 102, 0.1);
            color: var(--sifit-primary);
            border: 1px solid rgba(17, 85, 102, 0.25);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 18px;
            background: rgba(17, 85, 102, 0.08);
            color: var(--sifit-primary);
        }

        /* Tabs */
        .nav-tabs-custom {
            border-bottom: 2px solid #e2e8f0;
            padding: 0 20px;
            background: #ffffff;
        }

        .nav-tabs-custom .nav-link {
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 16px 20px;
            background: transparent;
            border-radius: 0;
            transition: all 0.2s ease;
        }

        .nav-tabs-custom .nav-link:hover {
            color: var(--sifit-primary);
            border-bottom-color: var(--sifit-accent);
        }

        .nav-tabs-custom .nav-link.active {
            color: var(--sifit-primary);
            border-bottom-color: var(--sifit-primary);
            background: transparent;
        }

        .nav-tabs-custom .nav-link i {
            color: var(--sifit-accent);
            margin-right: 6px;
        }

        /* Avatar Upload Preview Box */
        .avatar-upload-box {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 16px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .avatar-form-thumb {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--sifit-primary);
        }

        .btn-upload-avatar {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 8px;
            background: #ffffff;
            color: var(--sifit-primary);
            border: 1.5px solid var(--sifit-primary);
            transition: all 0.2s ease;
        }

        .btn-upload-avatar:hover {
            background: var(--sifit-primary);
            color: #ffffff;
        }

        /* Form Controls */
        .form-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        .input-group-text {
            background-color: #f8fafc;
            border-color: #cbd5e1;
            color: #64748b;
        }

        .form-control, .form-select {
            border-color: #cbd5e1;
            padding: 10px 14px;
            font-size: 14px;
            border-radius: 8px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--sifit-primary);
            box-shadow: 0 0 0 3px rgba(77, 182, 172, 0.25);
        }

        .btn-sifit-submit {
            background: linear-gradient(135deg, #115566 0%, #0d4452 45%, #4db6ac 100%);
            color: #ffffff;
            border: none;
            padding: 11px 26px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(17, 85, 102, 0.3);
            transition: all 0.2s ease;
        }

        .btn-sifit-submit:hover {
            background: linear-gradient(135deg, #0d4452 0%, #09313b 45%, #3b9b91 100%);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(77, 182, 172, 0.45);
        }

        .toggle-password {
            border-color: #cbd5e1;
            color: #64748b;
        }

        .toggle-password:hover {
            background: #f1f5f9;
            color: #334155;
        }
    </style>
</head>
<body>

    {{-- Minimal Top Navigation Bar --}}
    <header class="profile-topbar">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('frontend.home') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" class="brand-logo-img">
            </a>

            <div class="d-flex align-items-center gap-2">
                @if(Auth::user()->hasAnyRole(['super_admin', 'admin', 'operator', 'produsen_data', 'verifikator', 'validator', 'publisher']))
                    <a href="{{ route('dashboard') }}" class="btn-sifit-admin">
                        <i class="las la-tachometer-alt"></i> Panel Admin
                    </a>
                @endif

                <a href="{{ route('frontend.home') }}" class="btn-sifit-back">
                    <i class="las la-arrow-left"></i> Kembali ke Beranda
                </a>

                <a href="#" class="btn-sifit-logout" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
                    <i class="las la-power-off"></i> Keluar
                </a>

                <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    <input type="hidden" name="from" value="frontend">
                </form>
            </div>
        </div>
    </header>

    {{-- Main Profile Page Area --}}
    <main class="profile-main-content">
        <div class="container">

            {{-- Title & Breadcrumb --}}
            <div class="page-title-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div>
                    <h3>Profil Pengguna</h3>
                    <ul class="breadcrumb-custom">
                        <li><a href="{{ route('frontend.home') }}"><i class="las la-home"></i> Beranda</a></li>
                        <li><i class="las la-angle-right"></i></li>
                        <li>Profil Saya</li>
                    </ul>
                </div>
            </div>

            {{-- Alert Notifikasi Sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                    <i class="las la-check-circle fs-20 me-2" style="font-size: 22px;"></i>
                    <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Alert Error Global --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-1">
                        <i class="las la-exclamation-triangle fs-20 me-2" style="font-size: 22px;"></i>
                        <strong>Terjadi kesalahan saat menyimpan data:</strong>
                    </div>
                    <ul class="mb-0 ps-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">

                {{-- Left Column: Card Ringkasan Profil --}}
                <div class="col-lg-4 col-xl-4 mb-4">
                    <div class="card-custom">
                        <div class="p-4 text-center">
                            
                            {{-- Avatar Display --}}
                            <div class="profile-avatar-wrapper mb-3">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar-img" id="avatarPreviewSummary">
                                <span class="profile-avatar-badge" title="Akun Aktif"></span>
                            </div>
                            
                            <h5 class="fw-bold mb-1 text-truncate" style="color: #0f172a;">{{ $user->name }}</h5>
                            <p class="text-muted small mb-2">{{ $user->email }}</p>
                            
                            <div class="mb-3">
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        <span class="badge-role-sifit">
                                            <i class="las la-shield-alt me-1"></i>{{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge-role-sifit">
                                        <i class="las la-user me-1"></i>Pelanggan
                                    </span>
                                @endif
                            </div>

                            <div class="text-start mt-4 pt-3 border-top">
                                <h6 class="text-uppercase text-muted fw-bold mb-3" style="font-size: 11px; letter-spacing: 0.5px;">Informasi Akun</h6>
                                
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="las la-envelope"></i>
                                    </div>
                                    <div class="flex-grow-1 text-truncate">
                                        <small class="text-muted d-block" style="font-size: 11px;">Alamat Email</small>
                                        <span class="fw-medium text-dark">{{ $user->email }}</span>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="las la-phone"></i>
                                    </div>
                                    <div class="flex-grow-1 text-truncate">
                                        <small class="text-muted d-block" style="font-size: 11px;">Nomor Telepon / WA</small>
                                        <span class="fw-medium text-dark">{{ $user->phone ?: '-' }}</span>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="las la-calendar-alt"></i>
                                    </div>
                                    <div class="flex-grow-1 text-truncate">
                                        <small class="text-muted d-block" style="font-size: 11px;">Terdaftar Sejak</small>
                                        <span class="fw-medium text-dark">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Right Column: Form Tab Data & Password --}}
                <div class="col-lg-8 col-xl-8 mb-4">
                    <div class="card-custom">
                        
                        {{-- Tabs Header --}}
                        <ul class="nav nav-tabs-custom" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ !$errors->has('current_password') && !$errors->has('password') ? 'active' : '' }}" 
                                        id="tab-info" data-bs-toggle="tab" data-bs-target="#tab-content-info" type="button" role="tab" aria-selected="true">
                                    <i class="las la-user-edit"></i> Informasi Profil
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $errors->has('current_password') || $errors->has('password') ? 'active' : '' }}" 
                                        id="tab-security" data-bs-toggle="tab" data-bs-target="#tab-content-security" type="button" role="tab" aria-selected="false">
                                    <i class="las la-lock"></i> Ganti Kata Sandi
                                </button>
                            </li>
                        </ul>

                        <div class="p-4">
                            <div class="tab-content" id="profileTabsContent">
                                
                                {{-- TAB 1: EDIT INFORMASI PROFIL --}}
                                <div class="tab-pane fade {{ !$errors->has('current_password') && !$errors->has('password') ? 'show active' : '' }}" 
                                     id="tab-content-info" role="tabpanel" aria-labelledby="tab-info">
                                    
                                    <form action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        {{-- Foto Avatar Upload & Live Preview --}}
                                        <div class="avatar-upload-box">
                                            <img src="{{ $user->avatar_url }}" alt="Avatar Preview" id="avatarFormPreview" class="avatar-form-thumb">
                                            <div>
                                                <label class="btn-upload-avatar mb-1" for="avatarInput">
                                                    <i class="las la-camera"></i> Unggah Foto Profil
                                                </label>
                                                <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                                                <p class="text-muted mb-0 small">Format yang didukung: JPG, PNG, WEBP (Maksimal 2MB).</p>
                                                @error('avatar')
                                                    <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-user"></i></span>
                                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                                </div>
                                                @error('name')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-envelope"></i></span>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                                </div>
                                                @error('email')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label for="phone" class="form-label">Nomor Telepon / WhatsApp</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-phone"></i></span>
                                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                                                </div>
                                                @error('phone')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                            <button type="submit" class="btn-sifit-submit">
                                                <i class="las la-save fs-18"></i> Simpan Perubahan Profil
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                {{-- TAB 2: GANTI PASSWORD --}}
                                <div class="tab-pane fade {{ $errors->has('current_password') || $errors->has('password') ? 'show active' : '' }}" 
                                     id="tab-content-security" role="tabpanel" aria-labelledby="tab-security">
                                    
                                    <form action="{{ route('frontend.profile.update-password') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Kata Sandi Saat Ini <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="las la-key"></i></span>
                                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required placeholder="Masukkan kata sandi lama Anda">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#current_password">
                                                    <i class="las la-eye"></i>
                                                </button>
                                            </div>
                                            @error('current_password')
                                                <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label">Kata Sandi Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-lock"></i></span>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 8 karakter">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password">
                                                        <i class="las la-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <span class="text-danger small">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="las la-shield-alt"></i></span>
                                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi kata sandi baru">
                                                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password_confirmation">
                                                        <i class="las la-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-info py-2 px-3 small border-0 d-flex align-items-center mb-4">
                                            <i class="las la-info-circle fs-18 me-2"></i>
                                            <span>Gunakan kombinasi minimal 8 karakter dengan huruf dan angka untuk keamanan akun yang lebih baik.</span>
                                        </div>

                                        <div class="d-flex justify-content-end pt-3 border-top">
                                            <button type="submit" class="btn btn-warning text-white px-4 py-2 fw-medium d-inline-flex align-items-center gap-1">
                                                <i class="las la-shield-alt fs-18"></i> Perbarui Kata Sandi
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- Bootstrap Bundle JS --}}
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Live Preview Avatar saat memilih file baru
            const avatarInput = document.getElementById('avatarInput');
            const avatarFormPreview = document.getElementById('avatarFormPreview');
            const avatarSummary = document.getElementById('avatarPreviewSummary');

            if (avatarInput) {
                avatarInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            if (avatarFormPreview) avatarFormPreview.src = event.target.result;
                            if (avatarSummary) avatarSummary.src = event.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Toggle Show / Hide Password
            document.querySelectorAll('.toggle-password').forEach(function (button) {
                button.addEventListener('click', function () {
                    const targetSelector = this.getAttribute('data-target');
                    const targetInput = document.querySelector(targetSelector);
                    const icon = this.querySelector('i');

                    if (targetInput) {
                        if (targetInput.type === 'password') {
                            targetInput.type = 'text';
                            icon.classList.remove('la-eye');
                            icon.classList.add('la-eye-slash');
                        } else {
                            targetInput.type = 'password';
                            icon.classList.remove('la-eye-slash');
                            icon.classList.add('la-eye');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
