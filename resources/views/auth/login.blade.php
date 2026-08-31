<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Login - SiFit Backend</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Sistem Informasi Farmasi Riau" name="description" />

    <link rel="shortcut icon" href="{{ asset('assets/images/logo-riau.png') }}">
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
            width: 45%;
            background: linear-gradient(135deg, #2b1f54 0%, #4c35b0 45%, #6f6af8 75%, #22b783 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(34, 183, 131, 0.25) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(111, 106, 248, 0.4) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .auth-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: #fff;
        }

        .auth-left-content .brand-logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 1.5rem;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.3));
        }

        .auth-left-content h1 {
            font-size: 2.2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 0.4rem;
            color: #ffffff;
        }

        .auth-left-content .tagline {
            font-size: 0.95rem;
            color: #e0e7ff;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .feature-list {
            list-style: none;
            text-align: left;
            margin: 0 auto;
            max-width: 360px;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            font-size: 0.92rem;
            color: #f1f5f9;
            margin-bottom: 1rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            padding: 0.6rem 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .feature-list li .icon-wrap {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #22b783, #1aab6d);
            color: #ffffff;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
            box-shadow: 0 3px 8px rgba(34, 183, 131, 0.4);
        }

        .riau-badge {
            margin-top: 2.5rem;
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
            width: 22px;
            height: 22px;
            object-fit: contain;
        }

        /* ===== RIGHT PANEL ===== */
        .auth-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem;
            background: #ffffff;
        }

        .auth-form-card {
            width: 100%;
            max-width: 440px;
        }

        .auth-form-card .card-header-custom {
            margin-bottom: 2rem;
        }

        .auth-form-card .card-header-custom h2 {
            font-size: 1.7rem;
            font-weight: 800;
            color: #1e1b4b;
            margin-bottom: 0.3rem;
        }

        .auth-form-card .card-header-custom p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .auth-form-card .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #334155;
            margin-bottom: 0.4rem;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6f6af8;
            font-size: 1.15rem;
            z-index: 5;
        }

        .input-group-custom .form-control {
            padding-left: 42px;
            height: 48px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.25s ease;
            background: #f8fafc;
        }

        .input-group-custom .form-control:focus {
            background: #ffffff;
            border-color: #6f6af8;
            box-shadow: 0 0 0 4px rgba(111, 106, 248, 0.15);
        }

        .btn-auth {
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

        .btn-auth:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(111, 106, 248, 0.45);
            color: #fff;
        }

        .btn-auth:active { transform: translateY(0); }

        .divider-text {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #94a3b8;
            font-size: 0.8rem;
            margin: 1.25rem 0;
        }

        .divider-text::before, .divider-text::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .register-link {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }

        .register-link a {
            color: #6f6af8;
            font-weight: 700;
            text-decoration: none;
        }

        .register-link a:hover {
            color: #22b783;
            text-decoration: underline;
        }

        .form-check-input:checked {
            background-color: #22b783;
            border-color: #22b783;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .auth-left { width: 100%; min-height: 240px; padding: 2rem 1.5rem; }
            .auth-left-content .brand-logo { width: 60px; height: 60px; }
            .auth-left-content h1 { font-size: 1.5rem; }
            .feature-list { display: none; }
            .riau-badge { margin-top: 1rem; }
            .auth-right { padding: 2rem 1.5rem; }
        }
    </style>
</head>

<body>
    <!-- Left Branding Panel -->
    <div class="auth-left">
        <div class="auth-left-content">
            <!-- <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="SiFit Logo" class="brand-logo" -->
                 <!-- onerror="this.src='{{ asset('assets/images/logo-riau.png') }}'"> -->
            <h1>SIFIT</h1>
            <p class="tagline">Sistem Informasi Farmasi<br>Provinsi Riau</p>

            <ul class="feature-list">
                <li>
                    <div class="icon-wrap"><i class="las la-pills"></i></div>
                    <span>Manajemen data obat & farmasi</span>
                </li>
                <li>
                    <div class="icon-wrap"><i class="las la-layer-group"></i></div>
                    <span>Kategorisasi produk terstruktur</span>
                </li>
                <li>
                    <div class="icon-wrap"><i class="las la-newspaper"></i></div>
                    <span>Publikasi berita & informasi</span>
                </li>
                <li>
                    <div class="icon-wrap"><i class="las la-shield-alt"></i></div>
                    <span>Manajemen pengguna & hak akses</span>
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
                <h2>Selamat Datang</h2>
                <p>Masuk ke panel admin SIFIT untuk mengelola data farmasi.</p>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" style="border-radius:10px; font-size:0.875rem;">
                    <i class="las la-exclamation-circle fs-5"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-group-custom">
                        <i class="las la-envelope input-icon"></i>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               required autofocus>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label" for="userpassword">Password</label>
                    <div class="input-group-custom">
                        <i class="las la-lock input-icon"></i>
                        <input type="password"
                               class="form-control"
                               id="userpassword" name="password"
                               placeholder="Masukkan password"
                               required>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-size:0.875rem; color:#64748b;">
                            Ingat saya
                        </label>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-auth w-100 mb-3">
                    <i class="las la-sign-in-alt me-2"></i> Masuk ke Dashboard
                </button>

                <div class="divider-text">atau</div>

                <div class="register-link">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar akun baru</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
