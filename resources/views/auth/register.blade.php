<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Registrasi - SiFit Backend</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Sistem Informasi Farmasi Riau" name="description" />

    <!-- <link rel="shortcut icon" href="{{ asset('assets/images/logo-riau.png') }}"> -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Nunito', 'Segoe UI', sans-serif;
            background: #f8fafc;
        }

        /* ===== LEFT PANEL (Purple & Green Duotone Theme) ===== */
        .auth-left {
            width: 38%;
            background: linear-gradient(135deg, #2b1f54 0%, #4c35b0 45%, #6f6af8 75%, #22b783 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2.5rem;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            width: 340px;
            height: 340px;
            background: radial-gradient(circle, rgba(34, 183, 131, 0.25) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(111, 106, 248, 0.4) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            bottom: -40px;
            left: -40px;
        }

        .auth-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }

        .auth-left-content .brand-logo {
            width: 85px;
            height: 85px;
            object-fit: contain;
            margin-bottom: 1.2rem;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.3));
        }

        .auth-left-content h1 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0.4rem;
            color: #ffffff;
        }

        .auth-left-content .tagline {
            font-size: 0.9rem;
            color: #e0e7ff;
            line-height: 1.6;
            margin-bottom: 2.2rem;
        }

        .steps-list {
            list-style: none;
            text-align: left;
            width: 100%;
            padding: 0;
        }

        .steps-list li {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            font-size: 0.9rem;
            color: #f1f5f9;
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            padding: 0.65rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .steps-list li .step-num {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #22b783, #1aab6d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 800;
            flex-shrink: 0;
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(34, 183, 131, 0.4);
        }

        .riau-badge {
            margin-top: 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            background: rgba(15, 23, 42, 0.4);
            border: 1px solid rgba(34, 183, 131, 0.35);
            border-radius: 50px;
            padding: 0.55rem 1.3rem;
            font-size: 0.82rem;
            color: #f8fafc;
            backdrop-filter: blur(10px);
        }

        .riau-badge img {
            width: 20px;
            height: 20px;
            object-fit: contain;
        }

        /* ===== RIGHT PANEL ===== */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
            background: #ffffff;
            overflow-y: auto;
        }

        .auth-form-card {
            width: 100%;
            max-width: 520px;
        }

        .card-header-custom {
            margin-bottom: 1.75rem;
        }

        .card-header-custom h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e1b4b;
            margin-bottom: 0.3rem;
        }

        .card-header-custom p {
            color: #64748b;
            font-size: 0.875rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.825rem;
            color: #334155;
            margin-bottom: 0.35rem;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #6f6af8;
            font-size: 1.1rem;
            z-index: 5;
        }

        .input-group-custom .form-control,
        .input-group-custom select.form-control {
            padding-left: 40px;
            height: 46px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.875rem;
            transition: all 0.25s ease;
            background: #f8fafc;
        }

        .input-group-custom .form-control:focus,
        .input-group-custom select.form-control:focus {
            background: #ffffff;
            border-color: #6f6af8 !important;
            box-shadow: 0 0 0 4px rgba(111, 106, 248, 0.15) !important;
        }

        .form-section-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6f6af8;
            margin-bottom: 0.75rem;
            margin-top: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .btn-auth-register {
            height: 50px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            background: linear-gradient(135deg, #6f6af8 0%, #4f46e5 50%, #22b783 100%);
            border: none;
            color: #fff;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(111, 106, 248, 0.35);
        }

        .btn-auth-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(111, 106, 248, 0.45);
            color: #fff;
        }

        .login-link {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 1.2rem;
        }

        .login-link a {
            color: #6f6af8;
            font-weight: 700;
            text-decoration: none;
        }

        .login-link a:hover {
            color: #22b783;
            text-decoration: underline;
        }

        .required-star { color: #ef4444; }
        .optional-text { color: #94a3b8; font-weight: 400; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .auth-left { width: 100%; min-height: 220px; padding: 1.5rem; }
            .auth-left-content .brand-logo { width: 55px; height: 55px; }
            .auth-left-content h1 { font-size: 1.4rem; }
            .steps-list { display: none; }
            .auth-right { padding: 2rem 1.5rem; }
        }
    </style>
</head>

<body>
    <!-- Left Branding Panel -->
    <div class="auth-left">
        <div class="auth-left-content">
            <!-- <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="SiFit Logo" class="brand-logo" -->
                 <!-- onerror="this.src='{{ asset('assets/images/logo-riau.png') }}'">s -->
            <h1>SIFIT</h1>
            <p class="tagline">Sistem Informasi Farmasi <br>Provinsi Riau</p>

            <ul class="steps-list">
                <li>
                    <div class="step-num">1</div>
                    <span>Isi data diri dengan lengkap dan benar</span>
                </li>
                <li>
                    <div class="step-num">2</div>
                    <span>Pilih role & OPD yang sesuai jabatan Anda</span>
                </li>
                <li>
                    <div class="step-num">3</div>
                    <span>Akun siap digunakan untuk mengakses sistem</span>
                </li>
            </ul>

            <div class="riau-badge">
                <img src="{{ asset('assets/images/logo-riau.png') }}" alt="Riau">
                <span>Sistem informasi farmasi</span>
            </div>
        </div>
    </div>

    <!-- Right Form Panel -->
    <div class="auth-right">
        <div class="auth-form-card">
            <div class="card-header-custom">
                <h2>Buat Akun Baru</h2>
                <p>Daftarkan diri Anda sebagai pengguna sistem SIFIT.</p>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-start gap-2 mb-3" style="border-radius:10px; font-size:0.875rem;">
                    <i class="las la-exclamation-circle fs-5 mt-1"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                {{-- SECTION: Data Diri --}}
                <div class="form-section-label">Informasi Akun</div>

                {{-- Nama Lengkap --}}
                <div class="mb-3">
                    <label class="form-label" for="name">
                        Nama Lengkap <span class="required-star">*</span>
                    </label>
                    <div class="input-group-custom">
                        <i class="las la-user input-icon"></i>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name"
                               value="{{ old('name') }}"
                               placeholder="Nama lengkap Anda"
                               required autofocus>
                    </div>
                    @error('name')
                        <div class="text-danger mt-1" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label" for="email">
                        Alamat Email <span class="required-star">*</span>
                    </label>
                    <div class="input-group-custom">
                        <i class="las la-envelope input-icon"></i>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               required>
                    </div>
                    @error('email')
                        <div class="text-danger mt-1" style="font-size:0.8rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password (2 kolom) --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label" for="password">
                            Password <span class="required-star">*</span>
                        </label>
                        <div class="input-group-custom">
                            <i class="las la-lock input-icon"></i>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   placeholder="Min. 8 karakter"
                                   required>
                        </div>
                        @error('password')
                            <div class="text-danger mt-1" style="font-size:0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="password_confirmation">
                            Konfirmasi Password <span class="required-star">*</span>
                        </label>
                        <div class="input-group-custom">
                            <i class="las la-lock input-icon"></i>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="Ulangi password"
                                   required>
                        </div>
                    </div>
                </div>

                {{-- SECTION: Jabatan & OPD --}}
                <div class="form-section-label">Jabatan & Instansi</div>

                {{-- Role & OPD (2 kolom) --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label" for="role_id">
                            Role / Jabatan <span class="required-star">*</span>
                        </label>
                        <div class="input-group-custom">
                            <i class="las la-user-tag input-icon"></i>
                            <select class="form-control @error('role_id') is-invalid @enderror"
                                    id="role_id" name="role_id" required
                                    style="padding-left:40px;">
                                <option value="" disabled selected>-- Pilih Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('role_id')
                            <div class="text-danger mt-1" style="font-size:0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="opd_id">
                            OPD <span class="optional-text">(opsional)</span>
                        </label>
                        <div class="input-group-custom">
                            <i class="las la-building input-icon"></i>
                            <select class="form-control @error('opd_id') is-invalid @enderror"
                                    id="opd_id" name="opd_id"
                                    style="padding-left:40px;">
                                <option value="">-- Pilih OPD --</option>
                                @foreach ($opds as $opd)
                                    <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                                        {{ $opd->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('opd_id')
                            <div class="text-danger mt-1" style="font-size:0.8rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-auth-register w-100">
                    <i class="las la-user-plus me-2"></i> Daftar Sekarang
                </button>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk ke Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
