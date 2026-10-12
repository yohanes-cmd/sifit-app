<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIFIT - Sistem Informasi Farmasi Terintegrasi Pemprov Riau')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Official Favicon SIFIT --}}
    <link rel="shortcut icon" href="{{ asset('assets/images/logo-sifit.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo-sifit.png') }}">

    {{-- Modern Formal Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- CSS Template Dasar & Animasi --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

    {{-- CSS Tema Formal Pemerintahan SIFIT (#115566 & #4db6ac) --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/sifit-formal-theme.css') }}?v={{ time() }}">

    @stack('styles')
</head>

<body>

    <div class="boxed_wrapper">

        {{-- PRELOADER --}}
        <div class="preloader"></div>

        {{-- TOP BAR RESMI PEMERINTAH --}}
        <section class="top-bar-area">
            <div class="container">
                <div class="row sifit-top-row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="top-left">
                            <p>
                                <span class="gov-badge"><i class="fa fa-shield"></i> Portal Resmi Pemprov Riau</span>
                                <span class="gov-subtitle">SIFIT - Layanan Informasi Farmasi Terintegrasi</span>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="top-right sifit-top-right">
                            @php
                                $cartSession = session('cart', []);
                                $totalCartQty = array_sum(array_column($cartSession, 'quantity'));
                            @endphp

                            <ul class="social-links sifit-top-social">
                                <li><a href="#" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#" title="YouTube"><i class="fa fa-youtube-play"></i></a></li>
                            </ul>

                            <div class="top-divider"></div>

                            <ul class="top-auth-links sifit-top-actions">

                                @guest
                                    <li>
                                        <a href="{{ route('frontend.login') }}" class="btn-top-login">
                                            <i class="fa fa-sign-in"></i> Masuk
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('frontend.register') }}" class="btn-top-register">
                                            <i class="fa fa-user-plus"></i> Daftar
                                        </a>
                                    </li>
                                @else
                                    <li class="dropdown sifit-user-dropdown">
                                        <a href="#" class="dropdown-toggle user-top-badge" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-user-circle"></i>
                                            <span class="user-top-name">{{ Auth::user()->name }}</span>
                                            <i class="fa fa-caret-down user-top-caret"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right sifit-user-menu">


                                            @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                                                <li>
                                                    <a href="{{ route('dashboard') }}" class="sifit-dropdown-item">
                                                        <i class="fa fa-tachometer-alt sifit-item-icon"></i>
                                                        <span class="sifit-item-label">Panel Admin</span>
                                                    </a>
                                                </li>
                                                <li class="dropdown-divider-custom"></li>
                                            @endif

                                            <li>
                                                <a href="{{ route('frontend.profile') }}" class="sifit-dropdown-item">
                                                    <i class="fa fa-user sifit-item-icon"></i>
                                                    <span class="sifit-item-label">Profil Saya</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('frontend.cart.index') }}" class="sifit-dropdown-item">
                                                    <i class="fa fa-shopping-basket sifit-item-icon"></i>
                                                    <span class="sifit-item-label">Keranjang Saya</span>
                                                    @if($totalCartQty > 0)
                                                        <span class="sifit-item-badge">{{ $totalCartQty }}</span>
                                                    @endif
                                                </a>
                                            </li>

                                            <li class="dropdown-divider-custom"></li>

                                            <li>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('frontend-logout-form-top').submit();" class="sifit-dropdown-item item-logout">
                                                    <i class="fa fa-power-off sifit-item-icon"></i>
                                                    <span class="sifit-item-label">Keluar</span>
                                                </a>
                                                <form id="frontend-logout-form-top" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="from" value="frontend">
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- END TOP BAR --}}

        {{-- HEADER RESMI DENGAN LOGO SIFIT --}}
        <section class="header-area sifit-main-header">
            <div class="container">
                <div class="sifit-header-row">

                    {{-- LOGO RESMI SIFIT --}}
                    <div class="sifit-header-brand">
                        <a href="{{ route('frontend.home') }}" class="sifit-brand-wrapper">
                            <div class="sifit-brand-logos">
                                <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" class="logo-sifit">
                            </div>
                            <div class="sifit-brand-text">
                                <span class="title-gov">Pemerintah Provinsi Riau</span>
                                <h1 class="title-app" style="margin: 0; font-size: 20px;">SIFIT RIAU</h1>
                                <span class="title-desc">Sistem Informasi Farmasi Terintegrasi</span>
                            </div>
                        </a>
                    </div>

                    {{-- INFORMASI RESMI INSTANSI (FLEXBOX BERJARAK RAPI) --}}
                    <div class="sifit-header-widgets">
                        {{-- WIDGET 1: JAM LAYANAN --}}
                        <div class="sifit-header-widget-item">
                            <div class="widget-icon">
                                <i class="fa fa-clock-o"></i>
                            </div>
                            <div class="widget-text">
                                <span class="widget-label">Jam Layanan</span>
                                <span class="widget-value">Senin - Jumat: 08:00 - 16:00 WIB</span>
                            </div>
                        </div>

                        <div class="sifit-header-widget-divider"></div>

                        {{-- WIDGET 2: HELPDESK & CALL CENTER --}}
                        <div class="sifit-header-widget-item">
                            <div class="widget-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="widget-text">
                                <span class="widget-label">Layanan Informasi</span>
                                <span class="widget-value">0761-23547 / Dinkes Riau</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        {{-- END HEADER --}}

        {{-- NAVBAR UTAMA FORMAL (TEAL #115566) --}}
        <section class="mainmenu-area stricky">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <nav class="main-menu pull-left">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix">
                                <ul class="navigation clearfix">

                                    <li class="{{ request()->is('/') || request()->is('home') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a>
                                    </li>

                                    <li class="dropdown {{ request()->is('about*') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.about') }}">Tentang Kami</a>
                                        <ul>
                                            <li><a href="{{ route('frontend.about') }}">Profil & Visi Misi</a></li>
                                            <li><a href="{{ route('frontend.about.faq') }}">FAQ / Tanya Jawab</a></li>
                                        </ul>
                                    </li>

                                    <li class="{{ request()->is('berita*') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.berita') }}">Berita & Info</a>
                                    </li>

                                    <li class="dropdown {{ request()->is('obat*') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.obat') }}">Data Obat</a>
                                        <ul>
                                            <li><a href="{{ route('frontend.obat') }}">Katalog Obat</a></li>
                                            <li><a href="{{ route('frontend.obat.informasi') }}">Informasi Obat</a></li>
                                        </ul>
                                    </li>

                                    <li class="{{ request()->is('kontak') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.contact') }}">Kontak Kami</a>
                                    </li>

                                </ul>
                            </div>
                        </nav>

                        {{-- NAVBAR RIGHT ACTIONS (KERANJANG & PENCARIAN OBAT) --}}
                        <div class="sifit-navbar-actions pull-right">
                            <a href="{{ route('frontend.cart.index') }}" class="sifit-nav-cart-btn" title="Keranjang Permintaan Obat">
                                <i class="fa fa-shopping-basket"></i>
                                <span>Keranjang</span>
                                @if($totalCartQty > 0)
                                    <span class="sifit-nav-cart-badge">{{ $totalCartQty }}</span>
                                @endif
                            </a>
                            <a href="{{ route('frontend.obat') }}" class="sifit-nav-search-btn" title="Katalog Data Obat">
                                <i class="fa fa-medkit"></i>
                                <span>Cari Obat</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        {{-- END NAVBAR --}}

        {{-- ========================= --}}
        {{-- KONTEN HALAMAN UTAMA --}}
        {{-- ========================= --}}
        @yield('content')
        {{-- ========================= --}}

        {{-- FOOTER FORMAL PEMERINTAHAN --}}
        <footer id="kontak" class="footer-area">
            <div class="container">
                <div class="row">

                    {{-- TENTANG SIFIT & PEMPROV --}}
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-footer-widget pd-bottom50">
                            <div class="title">
                                <h3>SIFIT Provinsi Riau</h3>
                                <span class="border"></span>
                            </div>
                            <div class="our-info">
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                                    <div style="background: #ffffff; padding: 6px 12px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                        <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" style="height: 38px; object-fit: contain;">
                                    </div>
                                </div>
                                <p style="line-height: 24px; color: #cbd5e1;">
                                    Sistem Informasi Farmasi Terintegrasi (SIFIT) merupakan platform resmi pelayanan data obat, publikasi kefarmasian, dan dokumentasi kesehatan Pemerintah Provinsi Riau.
                                </p>
                                <a href="{{ route('frontend.about') }}" style="color: var(--sifit-accent); font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-top: 10px;">
                                    Profil Lengkap Sistem <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- TAUTAN NAVIGASI --}}
                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-footer-widget pd-bottom50">
                            <div class="title">
                                <h3>Menu Utama</h3>
                                <span class="border"></span>
                            </div>
                            <ul class="usefull-links">
                                <li><a href="{{ route('frontend.home') }}"><i class="fa fa-angle-right"></i> Beranda</a></li>
                                <li><a href="{{ route('frontend.about') }}"><i class="fa fa-angle-right"></i> Profil & Visi Misi</a></li>
                                <li><a href="{{ route('frontend.berita') }}"><i class="fa fa-angle-right"></i> Berita Farmasi</a></li>
                                <li><a href="{{ route('frontend.obat') }}"><i class="fa fa-angle-right"></i> Data Obat</a></li>
                                <li><a href="{{ route('frontend.contact') }}"><i class="fa fa-angle-right"></i> Kontak & Pengaduan</a></li>
                                <li><a href="{{ route('frontend.cart.index') }}"><i class="fa fa-angle-right"></i> Keranjang Obat</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- INFORMASI PENGGUNAAN OBAT --}}
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-footer-widget pd-bottom50">
                            <div class="title">
                                <h3>Layanan Publik</h3>
                                <span class="border"></span>
                            </div>
                            <ul class="usefull-links">
                                <li><a href="{{ route('frontend.obat.informasi') }}"><i class="fa fa-angle-right"></i> Panduan Penggunaan Obat</a></li>
                                <li><a href="{{ route('frontend.about.faq') }}"><i class="fa fa-angle-right"></i> Tanya Jawab (FAQ)</a></li>
                                <li><a href="{{ route('frontend.contact') }}"><i class="fa fa-angle-right"></i> Pengaduan & Kontak</a></li>
                                <li><a href="{{ route('login') }}"><i class="fa fa-angle-right"></i> Akses Panel Instansi</a></li>
                            </ul>
                        </div>
                    </div>

                    {{-- KONTAK RESMI --}}
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="single-footer-widget mar-bottom">
                            <div class="title">
                                <h3>Kontak Instansi</h3>
                                <span class="border"></span>
                            </div>
                            <ul class="footer-contact-info">
                                <li>
                                    <div class="icon-holder">
                                        <i class="fa fa-building-o"></i>
                                    </div>
                                    <div class="text-holder">
                                        <h5>Dinas Kesehatan Provinsi Riau</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-holder">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="text-holder">
                                        <h5>Jl. Cut Nyak Dien III, Pekanbaru, Riau</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-holder">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="text-holder">
                                        <h5>dinkes@riau.go.id</h5>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-holder">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <div class="text-holder">
                                        <h5>Senin - Jumat: 08:00 - 16:00 WIB</h5>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </footer>
        {{-- END FOOTER --}}

        {{-- FOOTER BOTTOM COPYRIGHT --}}
        <section class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="copyright-text">
                            <p>
                                Hak Cipta © {{ date('Y') }} <strong>Pemerintah Provinsi Riau</strong> - SIFIT (Sistem Informasi Farmasi Terintegrasi). Seluruh Hak Cipta Dilindungi.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="footer-social-links pull-right">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube-play"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        {{-- END FOOTER BOTTOM --}}

    </div>

    {{-- SCROLL TO TOP --}}
    <div class="scroll-to-top scroll-to-target" data-target="html">
        <span class="fa fa-arrow-up"></span>
    </div>

    {{-- JAVASCRIPT ASSETS --}}
    <script src="{{ asset('frontend/js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.countTo.js') }}"></script>
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/js/validation.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.mixitup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.bootstrap-touchspin.js') }}"></script>

    {{-- REVOLUTION SLIDER --}}
    <script src="{{ asset('frontend/assets/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>

    {{-- CUSTOM JS --}}
    <script src="{{ asset('frontend/js/custom.js') }}"></script>

    {{-- SweetAlert2 for Modern Modals --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>

</html>