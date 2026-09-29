@extends('layouts.app')

@section('title', 'Profil Pengguna - SiFit')

@push('css')
<style>
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
        border: 4px solid var(--bs-border-color, #e9ecef);
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: transform 0.25s ease, border-color 0.25s ease;
    }
    .profile-avatar-img:hover {
        transform: scale(1.03);
    }
    .profile-avatar-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #22c55e;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #ffffff;
    }
    .avatar-upload-btn {
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 20px;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border: 1px dashed #0d6efd;
        transition: all 0.2s ease;
    }
    .avatar-upload-btn:hover {
        background: #0d6efd;
        color: #ffffff;
    }
    .nav-tabs-custom .nav-link {
        color: #64748b;
        font-weight: 600;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 12px 20px;
        transition: all 0.2s ease;
    }
    .nav-tabs-custom .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
        background: transparent;
    }
    .info-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed var(--bs-border-color, #e2e8f0);
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 18px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row">
                <div class="col">
                    <h4 class="page-title">Profil Pengguna</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profil Saya</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Alert Notifikasi Sukses --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
    <i class="las la-check-circle fs-20 me-2"></i>
    <div><strong>Berhasil!</strong> {{ session('success') }}</div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- Alert Error Global --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center mb-1">
        <i class="las la-exclamation-triangle fs-20 me-2"></i>
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
    <!-- Card Ringkasan Profil (Kiri) -->
    <div class="col-lg-4 col-xl-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="profile-avatar-wrapper mb-3">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="profile-avatar-img" id="avatarPreviewSummary">
                    <span class="profile-avatar-badge" title="Akun Aktif"></span>
                </div>
                
                <h5 class="fw-bold mb-1 text-truncate">{{ $user->name }}</h5>
                <p class="text-muted small mb-2">{{ $user->email }}</p>
                
                <div class="mb-3">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 fs-12 fw-semibold">
                                <i class="las la-shield-alt me-1"></i>{{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    @else
                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1 fs-12">User</span>
                    @endif
                </div>

                <div class="text-start mt-4 pt-3 border-top">
                    <h6 class="text-uppercase text-muted fs-11 fw-bold mb-3 ls-1">Informasi Akun</h6>
                    
                    <div class="info-item">
                        <div class="info-icon bg-primary-subtle text-primary">
                            <i class="las la-building"></i>
                        </div>
                        <div class="flex-grow-1 text-truncate">
                            <small class="text-muted d-block">Instansi / OPD</small>
                            <span class="fw-medium">{{ $user->opd ?: '-' }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon bg-success-subtle text-success">
                            <i class="las la-phone"></i>
                        </div>
                        <div class="flex-grow-1 text-truncate">
                            <small class="text-muted d-block">Nomor Telepon</small>
                            <span class="fw-medium">{{ $user->phone ?: '-' }}</span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon bg-info-subtle text-info">
                            <i class="las la-calendar-alt"></i>
                        </div>
                        <div class="flex-grow-1 text-truncate">
                            <small class="text-muted d-block">Terdaftar Sejak</small>
                            <span class="fw-medium">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Tab Data & Password (Kanan) -->
    <div class="col-lg-8 col-xl-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header border-bottom-0 pb-0 bg-transparent">
                <ul class="nav nav-tabs nav-tabs-custom card-header-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ !$errors->has('current_password') && !$errors->has('password') ? 'active' : '' }}" 
                                id="tab-info" data-bs-toggle="tab" data-bs-target="#tab-content-info" type="button" role="tab" aria-selected="true">
                            <i class="las la-user-edit me-1 fs-16 align-text-bottom"></i> Informasi Profil
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $errors->has('current_password') || $errors->has('password') ? 'active' : '' }}" 
                                id="tab-security" data-bs-toggle="tab" data-bs-target="#tab-content-security" type="button" role="tab" aria-selected="false">
                            <i class="las la-lock me-1 fs-16 align-text-bottom"></i> Ganti Password
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="profileTabsContent">
                    
                    <!-- Tab 1: Edit Informasi Profil -->
                    <div class="tab-pane fade {{ !$errors->has('current_password') && !$errors->has('password') ? 'show active' : '' }}" 
                         id="tab-content-info" role="tabpanel" aria-labelledby="tab-info">
                        
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Foto Avatar Upload & Live Preview -->
                            <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light-subtle rounded-3 border">
                                <img src="{{ $user->avatar_url }}" alt="Avatar Preview" id="avatarFormPreview" class="rounded-circle object-fit-cover border" style="width: 70px; height: 70px;">
                                <div>
                                    <label class="avatar-upload-btn mb-1" for="avatarInput">
                                        <i class="las la-camera"></i> Ubah Foto Profil
                                    </label>
                                    <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <p class="text-muted mb-0 small">Format: JPG, PNG, WEBP. Maks 2MB.</p>
                                    @error('avatar')
                                        <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="las la-user"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
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
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-semibold">Nomor Telepon / WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="las la-phone"></i></span>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                                    </div>
                                    @error('phone')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="opd" class="form-label fw-semibold">Instansi / OPD</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="las la-hospital"></i></span>
                                        <select class="form-select @error('opd') is-invalid @enderror" id="opd" name="opd">
                                            <option value="">-- Pilih Instansi / OPD --</option>
                                            @foreach($opds as $opd)
                                                <option value="{{ $opd->nama_opd }}" {{ old('opd', $user->opd) == $opd->nama_opd ? 'selected' : '' }}>
                                                    {{ $opd->nama_opd }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('opd')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-2 border-top">
                                <button type="submit" class="btn btn-primary px-4 py-2 fw-medium d-inline-flex align-items-center">
                                    <i class="las la-save me-1 fs-18"></i> Simpan Perubahan Profil
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: Ganti Password -->
                    <div class="tab-pane fade {{ $errors->has('current_password') || $errors->has('password') ? 'show active' : '' }}" 
                         id="tab-content-security" role="tabpanel" aria-labelledby="tab-security">
                        
                        <form action="{{ route('profile.update-password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required placeholder="Masukkan password lama Anda">
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
                                    <label for="password" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="las la-lock"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 6 karakter">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password">
                                            <i class="las la-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="las la-lock"></i></span>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ulangi password baru">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="#password_confirmation">
                                            <i class="las la-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info py-2 px-3 small border-0 d-flex align-items-center mb-4">
                                <i class="las la-info-circle fs-18 me-2"></i>
                                <span>Gunakan kombinasi minimal 6 karakter dengan huruf dan angka untuk keamanan akun yang lebih baik.</span>
                            </div>

                            <div class="d-flex justify-content-end pt-2 border-top">
                                <button type="submit" class="btn btn-warning text-white px-4 py-2 fw-medium d-inline-flex align-items-center">
                                    <i class="las la-shield-alt me-1 fs-18"></i> Perbarui Password
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush