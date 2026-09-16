<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Petugas - Panel Admin SIFIT</title>
    
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-riau.png') }}">

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #110d26;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 25px 20px;
        }

        /* ===== BACKGROUND GLOWS & GRADIENT ===== */
        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #130d29 0%, #201344 35%, #301b63 70%, #0f3d36 100%);
            z-index: 1;
        }

        .bg-glow-1 {
            position: fixed;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(123, 69, 240, 0.4) 0%, rgba(0, 0, 0, 0) 70%);
            top: -120px;
            left: -120px;
            border-radius: 50%;
            z-index: 2;
        }

        .bg-glow-2 {
            position: fixed;
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.3) 0%, rgba(0, 0, 0, 0) 70%);
            bottom: -120px;
            right: -120px;
            border-radius: 50%;
            z-index: 2;
        }

        /* ===== MAIN CONTAINER CARD ===== */
        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1120px;
            background: rgba(22, 17, 49, 0.55);
            backdrop-filter: blur(30px) saturate(200%);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 28px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            overflow: hidden;
            display: flex;
            min-height: 660px;
        }

        /* Top Back to Website Button */
        .btn-back-home {
            position: absolute;
            top: 24px;
            left: 28px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #e0e7ff;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 30px;
            transition: all 0.3s ease;
            z-index: 20;
        }

        .btn-back-home:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateX(-3px);
        }

        /* ===== LEFT HERO SECTION ===== */
        .auth-hero {
            flex: 1.05;
            padding: 90px 45px 50px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .brand-badge img {
            height: 48px;
            width: auto;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.4));
        }

        .brand-badge .brand-title {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .brand-badge .brand-tag {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(123, 69, 240, 0.35);
            border: 1px solid rgba(155, 109, 247, 0.55);
            color: #e0d4fc;
            padding: 3px 10px;
            border-radius: 12px;
            margin-left: 5px;
        }

        .hero-title {
            font-size: 34px;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
        }

        .hero-title span {
            background: linear-gradient(135deg, #c4b0f9 0%, #7b45f0 50%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 14px;
            color: #cbd5e1;
            line-height: 1.65;
            margin-bottom: 30px;
            max-width: 440px;
        }

        .feature-pills {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 400px;
        }

        .feature-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 16px;
            border-radius: 14px;
            font-size: 13px;
            color: #f1f5f9;
        }

        .feature-pill .icon-box {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #7b45f0, #10b981);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #ffffff;
            flex-shrink: 0;
            box-shadow: 0 3px 8px rgba(123, 69, 240, 0.4);
        }

        /* ===== RIGHT FORM CARD SECTION ===== */
        .auth-form-wrapper {
            flex: 1;
            padding: 40px 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.03);
            border-left: 1px solid rgba(255, 255, 255, 0.08);
        }

        .form-glass-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(30px) saturate(200%);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 22px;
            padding: 28px 24px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .form-glass-card h3 {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .form-glass-card p.subtitle {
            font-size: 12.5px;
            color: #cbd5e1;
            margin-bottom: 16px;
        }

        .form-grid-row {
            display: flex;
            gap: 12px;
        }

        .form-grid-col {
            flex: 1;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 13px;
        }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 5px;
        }

        .input-group-glass {
            position: relative;
        }

        .input-group-glass input,
        .input-group-glass select {
            width: 100%;
            height: 42px;
            background: #ffffff;
            border: 1.5px solid transparent;
            border-radius: 9px;
            padding: 8px 12px 8px 38px;
            font-size: 13px;
            color: #0f172a;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .input-group-glass input:focus,
        .input-group-glass select:focus {
            border-color: #7b45f0;
            box-shadow: 0 0 0 3px rgba(123, 69, 240, 0.35);
        }

        .input-group-glass .icon-field {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #7b45f0;
            font-size: 13.5px;
            pointer-events: none;
        }

        /* Submit Button (Purple to Teal Gradient) */
        .btn-submit-glow {
            width: 100%;
            height: 45px;
            background: linear-gradient(135deg, #7b45f0 0%, #6528e0 50%, #10b981 100%);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 18px rgba(123, 69, 240, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            margin-top: 12px;
        }

        .btn-submit-glow:hover {
            background: linear-gradient(135deg, #6528e0 0%, #5218cb 50%, #059669 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(123, 69, 240, 0.65);
        }

        .btn-submit-glow:active {
            transform: translateY(0);
        }

        /* Footer Link */
        .form-footer-link {
            text-align: center;
            margin-top: 15px;
            padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            font-size: 12.5px;
            color: #cbd5e1;
        }

        .form-footer-link a {
            color: #c4b0f9;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-footer-link a:hover {
            color: #34d399;
            text-decoration: underline;
        }

        /* Alert Styling */
        .alert-glass-danger {
            background: rgba(239, 68, 68, 0.25);
            border: 1px solid rgba(239, 68, 68, 0.4);
            backdrop-filter: blur(10px);
            color: #fecaca;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            margin-bottom: 14px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .auth-container {
                flex-direction: column;
                max-width: 540px;
            }

            .auth-hero {
                padding: 70px 30px 25px;
                text-align: center;
                align-items: center;
            }

            .hero-title {
                font-size: 26px;
            }

            .hero-desc {
                font-size: 13px;
            }

            .feature-pills {
                width: 100%;
            }

            .auth-form-wrapper {
                border-left: none;
                border-top: 1px solid rgba(255, 255, 255, 0.08);
                padding: 25px 20px 30px;
            }

            .form-grid-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>

    {{-- Background glowing layers --}}
    <div class="bg-layer"></div>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    {{-- Main Container Card --}}
    <div class="auth-container">
        
        {{-- Back to Website Button --}}
        <a href="{{ route('frontend.home') }}" class="btn-back-home">
            <i class="fa-solid fa-arrow-left"></i> Website SIFIT
        </a>

        {{-- Left Hero Info --}}
        <div class="auth-hero">
            <div class="brand-badge">
                <img src="{{ asset('assets/images/logo-riau.png') }}" alt="Logo Riau">
                <span class="brand-title">SIFIT</span>
                <span class="brand-tag">Registrasi Petugas</span>
            </div>

            <h1 class="hero-title">
                Pendaftaran Akun <span>Pengelola SIFIT</span>
            </h1>

            <p class="hero-desc">
                Daftarkan akun petugas resmi untuk mengelola data kefarmasian, perizinan, distribusi obat, dan tata kelola instansi Provinsi Riau.
            </p>

            <div class="feature-pills">
                <div class="feature-pill">
                    <div class="icon-box"><i class="fa-solid fa-user-check"></i></div>
                    <div>Verifikasi Otoritas Instansi & OPD</div>
                </div>
                <div class="feature-pill">
                    <div class="icon-box"><i class="fa-solid fa-id-card-clip"></i></div>
                    <div>Pemetaan Hak Akses (Role Base)</div>
                </div>
                <div class="feature-pill">
                    <div class="icon-box"><i class="fa-solid fa-lock"></i></div>
                    <div>Keamanan Data Terenkripsi</div>
                </div>
            </div>
        </div>

        {{-- Right Form Area (Glassmorphism) --}}
        <div class="auth-form-wrapper">
            <div class="form-glass-card">
                <h3>Buat Akun Petugas</h3>
                <p class="subtitle">Lengkapi identitas jabatan dan instansi Anda</p>

                {{-- Alert Messages --}}
                @if ($errors->any())
                    <div class="alert-glass-danger">
                        <ul style="margin: 0; padding-left: 16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-group-glass">
                            <i class="fa-solid fa-user icon-field"></i>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap petugas" required autofocus>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group-glass">
                            <i class="fa-solid fa-envelope icon-field"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="petugas@riau.go.id" required>
                        </div>
                    </div>

                    {{-- Role & OPD (2 Kolom) --}}
                    <div class="form-grid-row">
                        <div class="form-grid-col form-group">
                            <label for="role_id" class="form-label">Role / Jabatan</label>
                            <div class="input-group-glass">
                                <i class="fa-solid fa-user-tag icon-field"></i>
                                <select id="role_id" name="role_id" required>
                                    <option value="" disabled selected>-- Pilih Role --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-grid-col form-group">
                            <label for="opd_id" class="form-label">Instansi / OPD</label>
                            <div class="input-group-glass">
                                <i class="fa-solid fa-building-columns icon-field"></i>
                                <select id="opd_id" name="opd_id">
                                    <option value="">-- Pilih OPD (Opsional) --</option>
                                    @foreach ($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Password & Konfirmasi (2 Kolom) --}}
                    <div class="form-grid-row">
                        <div class="form-grid-col form-group">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <div class="input-group-glass">
                                <i class="fa-solid fa-lock icon-field"></i>
                                <input type="password" id="password" name="password" placeholder="Min. 8 karakter" required>
                            </div>
                        </div>

                        <div class="form-grid-col form-group">
                            <label for="password_confirmation" class="form-label">Ulangi Sandi</label>
                            <div class="input-group-glass">
                                <i class="fa-solid fa-shield-halved icon-field"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang sandi" required>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-submit-glow">
                        <i class="fa-solid fa-user-plus"></i> Daftarkan Akun Petugas
                    </button>
                </form>

                <div class="form-footer-link">
                    Sudah memiliki akun petugas? <a href="{{ route('login') }}">Masuk ke Dashboard</a>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
