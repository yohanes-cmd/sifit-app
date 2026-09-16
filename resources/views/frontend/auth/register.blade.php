<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - SIFIT Farmasi Riau</title>
    
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-riau.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/images/favicon/apple-touch-icon.png') }}">

    {{-- Google Fonts & Icons --}}
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
            background: #0b1528;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 25px 20px;
        }

        /* ===== BACKGROUND WRAPPER ===== */
        .bg-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('frontend/images/slides/2.jpg') }}');
            background-size: cover;
            background-position: center;
            filter: brightness(0.65) saturate(1.2);
            z-index: 1;
        }

        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(8, 28, 58, 0.88) 0%, rgba(3, 146, 206, 0.45) 50%, rgba(10, 20, 40, 0.90) 100%);
            backdrop-filter: blur(4px);
            z-index: 2;
        }

        /* ===== MAIN WRAPPER CARD ===== */
        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1100px;
            background: rgba(15, 25, 45, 0.45);
            backdrop-filter: blur(25px) saturate(190%);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 28px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            overflow: hidden;
            display: flex;
            min-height: 640px;
        }

        /* Back to Home Button */
        .btn-back-home {
            position: absolute;
            top: 24px;
            left: 28px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #e2e8f0;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 16px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            transition: all 0.3s ease;
            z-index: 20;
        }

        .btn-back-home:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
            transform: translateX(-3px);
        }

        /* ===== LEFT HERO SECTION ===== */
        .auth-hero {
            flex: 1.1;
            padding: 90px 45px 50px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .brand-badge img {
            height: 48px;
            width: auto;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.3));
        }

        .brand-badge .brand-title {
            font-size: 24px;
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
            background: rgba(3, 146, 206, 0.35);
            border: 1px solid rgba(3, 146, 206, 0.6);
            color: #7dd3fc;
            padding: 3px 10px;
            border-radius: 12px;
            margin-left: 5px;
        }

        .hero-title {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.18;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
        }

        .hero-title span {
            background: linear-gradient(135deg, #38bdf8 0%, #0392ce 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 14.5px;
            color: #cbd5e1;
            line-height: 1.65;
            margin-bottom: 30px;
            max-width: 440px;
        }

        .feature-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .feature-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 12.5px;
            color: #f1f5f9;
        }

        .feature-pill i {
            color: #38bdf8;
        }

        /* ===== RIGHT FORM CARD SECTION ===== */
        .auth-form-wrapper {
            flex: 0.95;
            padding: 40px 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-glass-card {
            width: 100%;
            max-width: 390px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(30px) saturate(200%);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 22px;
            padding: 30px 28px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        }

        .form-glass-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .form-glass-card p.subtitle {
            font-size: 13px;
            color: #cbd5e1;
            margin-bottom: 18px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 6px;
        }

        .input-group-glass {
            position: relative;
        }

        .input-group-glass input {
            width: 100%;
            height: 44px;
            background: #ffffff;
            border: 1.5px solid transparent;
            border-radius: 10px;
            padding: 10px 14px 10px 42px;
            font-size: 13.5px;
            color: #0f172a;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .input-group-glass input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.3);
        }

        .input-group-glass .icon-field {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 14px;
        }

        /* Submit Button */
        .btn-submit-glow {
            width: 100%;
            height: 46px;
            background: linear-gradient(135deg, #0392ce 0%, #0284c7 100%);
            border: none;
            border-radius: 10px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(3, 146, 206, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .btn-submit-glow:hover {
            background: linear-gradient(135deg, #0277a8 0%, #0369a1 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(3, 146, 206, 0.55);
        }

        .btn-submit-glow:active {
            transform: translateY(0);
        }

        /* Footer Link */
        .form-footer-link {
            text-align: center;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            font-size: 13px;
            color: #cbd5e1;
        }

        .form-footer-link a {
            color: #38bdf8;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-footer-link a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Alert Styling */
        .alert-glass-danger {
            background: rgba(239, 68, 68, 0.25);
            border: 1px solid rgba(239, 68, 68, 0.4);
            backdrop-filter: blur(10px);
            color: #fecaca;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12.5px;
            margin-bottom: 14px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .auth-container {
                flex-direction: column;
                max-width: 540px;
            }

            .auth-hero {
                padding: 70px 30px 30px;
                text-align: center;
                align-items: center;
            }

            .hero-title {
                font-size: 28px;
            }

            .hero-desc {
                font-size: 13.5px;
            }

            .feature-pills {
                justify-content: center;
            }

            .auth-form-wrapper {
                border-left: none;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding: 30px 25px 35px;
            }
        }
    </style>
</head>
<body>

    {{-- Background layers --}}
    <div class="bg-layer"></div>
    <div class="bg-overlay"></div>

    {{-- Main Container Card --}}
    <div class="auth-container">
        
        {{-- Back Button --}}
        <a href="{{ route('frontend.home') }}" class="btn-back-home">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>

        {{-- Left Hero Info --}}
        <div class="auth-hero">
            <div class="brand-badge">
                <img src="{{ asset('assets/images/logo-riau.png') }}" alt="Logo Riau">
                <span class="brand-title">SIFIT</span>
                <span class="brand-tag">Farmasi Riau</span>
            </div>

            <h1 class="hero-title">
                Bergabung dengan <span>SIFIT Riau</span>
            </h1>

            <p class="hero-desc">
                Buat akun pelanggan untuk mendapatkan akses penuh informasi ketersediaan obat, edukasi farmasi, dan layanan konsultasi terintegrasi.
            </p>

            <div class="feature-pills">
                <div class="feature-pill">
                    <i class="fa-solid fa-user-shield"></i> Pendaftaran Mudah
                </div>
                <div class="feature-pill">
                    <i class="fa-solid fa-hospital"></i> Data Terintegrasi
                </div>
                <div class="feature-pill">
                    <i class="fa-solid fa-clock"></i> Akses 24 Jam
                </div>
            </div>
        </div>

        {{-- Right Form Area (Glassmorphism) --}}
        <div class="auth-form-wrapper">
            <div class="form-glass-card">
                <h3>Buat Akun Baru</h3>
                <p class="subtitle">Lengkapi form berikut untuk mendaftar</p>

                @if ($errors->any())
                    <div class="alert-glass-danger">
                        <ul style="margin: 0; padding-left: 16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('frontend.register.post') }}" method="POST">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-group-glass">
                            <i class="fa-solid fa-user icon-field"></i>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" required autofocus>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-group-glass">
                            <i class="fa-solid fa-envelope icon-field"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group-glass">
                            <i class="fa-solid fa-lock icon-field"></i>
                            <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <div class="input-group-glass">
                            <i class="fa-solid fa-shield-halved icon-field"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-submit-glow">
                        <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                    </button>
                </form>

                <div class="form-footer-link">
                    Sudah memiliki akun? <a href="{{ route('frontend.login') }}">Masuk di Sini</a>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
