<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>@yield('title', 'SIFIT')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">

    {{-- Favicon --}}
    <link rel="apple-touch-icon"
        sizes="180x180"
        href="{{ asset('frontend/images/favicon/apple-touch-icon.png') }}">

    <link rel="icon"
        type="image/png"
        sizes="32x32"
        href="{{ asset('frontend/images/favicon/favicon-32x32.png') }}">

    <link rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{ asset('frontend/images/favicon/favicon-16x16.png') }}">

    @stack('styles')
</head>

<body>

    <div class="boxed_wrapper">

        {{-- PRELOADER --}}
        <div class="preloader"></div>

        {{-- TOP BAR --}}
        <section class="top-bar-area">

            <div class="container">

                <div class="row">

                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">

                        <div class="top-left">

                            <p>
                                <span class="flaticon-phone"></span>
                                Layanan Informasi Farmasi SIFIT
                            </p>

                        </div>

                    </div>

                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">

                        <div class="top-right clearfix">

                            <ul class="social-links">

                                <li>
                                    <a href="#">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        </section>
        {{-- END TOP BAR --}}

        {{-- HEADER --}}
        <section class="header-area">

            <div class="container">

                <div class="row">

                    {{-- LOGO --}}
                    <div class="col-lg-3 col-md-3">

                        <div class="logo">

                            <a href="{{ route('frontend.home') }}">
                                <img
                                    src="{{ asset('frontend/images/resources/logo.png') }}"
                                    alt="Logo SIFIT">

                            </a>

                        </div>

                    </div>

                    {{-- HEADER RIGHT --}}
                    <div class="col-lg-9 col-md-9">

                        <div class="header-right">

                            <ul>

                                {{-- CONTACT --}}
                                <li>

                                    <div class="icon-holder">
                                        <span class="flaticon-technology"></span>
                                    </div>

                                    <div class="text-holder">

                                        <h4>Hubungi Kami</h4>

                                        <span>
                                            Layanan Informasi SIFIT
                                        </span>

                                    </div>

                                </li>

                                {{-- LOCATION --}}
                                <li>

                                    <div class="icon-holder">
                                        <span class="flaticon-pin"></span>
                                    </div>

                                    <div class="text-holder">

                                        <h4>SIFIT</h4>

                                        <span>
                                            Sistem Informasi Farmasi
                                        </span>

                                    </div>

                                </li>

                                {{-- HOURS --}}
                                <li>

                                    <div class="icon-holder">
                                        <span class="flaticon-agenda"></span>
                                    </div>

                                    <div class="text-holder">

                                        <h4>Jam Layanan</h4>

                                        <span>
                                            Senin - Jumat
                                        </span>

                                    </div>

                                </li>

                            </ul>

                            {{-- SEARCH BUTTON --}}
                            <div class="search-button pull-right">

                                <div class="toggle-search">

                                    <button type="button">

                                        <i
                                            class="fa fa-search"
                                            aria-hidden="true"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>
        {{-- END HEADER --}}

        {{-- SEARCH AREA --}}
        <section class="header-search">

            <div class="container">

                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="search-form pull-right">

                            <form action="{{ route('frontend.berita') }}" method="GET">

                                <div class="search">

                                    <input
                                        type="search"
                                        name="search"
                                        placeholder="Cari informasi...">

                                    <button type="submit">

                                        <i
                                            class="fa fa-search"
                                            aria-hidden="true"></i>

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </section>
        {{-- END SEARCH AREA --}}

        {{-- NAVBAR --}}
        <section class="mainmenu-area stricky">

            <div class="container">

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <nav class="main-menu pull-left">

                            <div class="navbar-header">

                                <button
                                    type="button"
                                    class="navbar-toggle"
                                    data-toggle="collapse"
                                    data-target=".navbar-collapse">

                                    <span class="icon-bar"></span>

                                    <span class="icon-bar"></span>

                                    <span class="icon-bar"></span>

                                </button>

                            </div>

                            <div class="navbar-collapse collapse clearfix">

                                <ul class="navigation clearfix">

                                    <li class="{{ request()->is('/') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.home') }}">Beranda</a>
                                    </li>

                                    <li class="dropdown {{ request()->is('about') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.about') }}">Tentang Kami</a>
                                        <ul>
                                            <li><a href="{{ route('frontend.about') }}#tentang-sifit">Tentang SIFIT</a></li>
                                            <li><a href="{{ route('frontend.about.visimisi') }}#visi-misi">Visi & Misi</a></li>
                                            <li><a href="{{ route('frontend.about.fitur') }}#fitur-sifit">Fitur SIFIT</a></li>
                                            <li><a href="{{ route('frontend.about.faq') }}#faq">FAQ</a></li>
                                            <li><a href="{{ route('frontend.about.galeri') }}#galeri">Galeri</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown {{ request()->is('berita*') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.berita') }}">Berita</a>
                                        <ul>
                                            <li>
                                                <a href="{{ route('frontend.berita') }}">Semua Berita</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('frontend.berita.kategori') }}">Kategori Berita</a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="dropdown {{ request()->is('obat*') ? 'current' : '' }}">
                                        <a href="{{ route('frontend.obat') }}">Data Obat</a>
                                        <ul>
                                            <li><a href="{{ route('frontend.obat') }}">Daftar Obat</a></li>
                                            <li><a href="{{ route('frontend.obat.informasi') }}">Informasi Obat</a></li>
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="{{ route('frontend.contact') }}">Kontak</a>
                                    </li>

                                </ul>

                            </div>

                        </nav>

                        {{-- NAVBAR RIGHT --}}
                        <div class="mainmenu-right-box pull-right">

                            <div class="consultation-button">

                                <a href="{{ route('frontend.obat') }}">Informasi Farmasi</a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>
        {{-- END NAVBAR --}}

        {{-- ========================= --}}
        {{-- KONTEN HALAMAN --}}
        {{-- ========================= --}}

        @yield('content')

        {{-- ========================= --}}
        {{-- END KONTEN --}}
        {{-- ========================= --}}

        {{-- FOOTER --}}
        <footer id="kontak" class="footer-area">

            <div class="container">

                <div class="row">

                    {{-- ABOUT SIFIT --}}
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="single-footer-widget pd-bottom50">

                            <div class="title">

                                <h3>Tentang SIFIT</h3>

                                <span class="border"></span>

                            </div>

                            <div class="our-info">

                                <p>
                                    SIFIT merupakan Sistem Informasi Farmasi
                                    yang menyediakan informasi obat dan
                                    informasi kefarmasian untuk masyarakat.
                                </p>

                                <p class="mar-top">
                                    SIFIT membantu masyarakat mendapatkan
                                    informasi secara lebih mudah, cepat,
                                    dan terpercaya.
                                </p>

                                <a href="{{ route('frontend.about') }}">

                                    Selengkapnya

                                    <i
                                        class="fa fa-caret-right"
                                        aria-hidden="true"></i>

                                </a>

                            </div>

                        </div>

                    </div>

                    {{-- LINKS --}}
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="single-footer-widget pd-bottom50">

                            <div class="title">

                                <h3>Tautan</h3>

                                <span class="border"></span>

                            </div>

                            <ul class="usefull-links fl-lft">

                                <li>
                                    <a href="{{ route('frontend.home') }}">Beranda</a>
                                </li>

                                <li>
                                    <a href="{{ route('frontend.about') }}">
                                        Tentang Kami
                                    </a>
                                </li>

                                <li>
                                    <a href="{{ route('frontend.berita') }}">Berita</a>
                                </li>

                            </ul>

                            <ul class="usefull-links">

                                <li>
                                    <a href="{{ route('frontend.obat') }}">Data Obat</a>
                                </li>

                                <li>
                                    <a href="#kontak">Kontak</a>
                                </li>

                                <li>
                                    <a href="{{ route('frontend.about') }}#faq">FAQ</a>
                                </li>

                            </ul>

                        </div>

                    </div>

                    {{-- CONTACT --}}
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="single-footer-widget mar-bottom">

                            <div class="title">

                                <h3>Kontak</h3>

                                <span class="border"></span>

                            </div>

                            <ul class="footer-contact-info">

                                <li>

                                    <div class="icon-holder">

                                        <span class="flaticon-pin"></span>

                                    </div>

                                    <div class="text-holder">

                                        <h5>
                                            Sistem Informasi Farmasi
                                            <br>
                                            SIFIT
                                        </h5>

                                    </div>

                                </li>

                                <li>

                                    <div class="icon-holder">

                                        <span class="flaticon-interface"></span>

                                    </div>

                                    <div class="text-holder">

                                        <h5>
                                            info@sifit.id
                                        </h5>

                                    </div>

                                </li>

                                <li>

                                    <div class="icon-holder">

                                        <span class="flaticon-technology-1"></span>

                                    </div>

                                    <div class="text-holder">

                                        <h5>
                                            Layanan Informasi SIFIT
                                        </h5>

                                    </div>

                                </li>

                                <li>

                                    <div class="icon-holder">

                                        <span class="flaticon-clock"></span>

                                    </div>

                                    <div class="text-holder">

                                        <h5>
                                            Senin - Jumat
                                        </h5>

                                    </div>

                                </li>

                            </ul>

                        </div>

                    </div>

                    {{-- CONTACT FORM --}}
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">

                        <div class="single-footer-widget clearfix">

                            <div class="title">

                                <h3>Hubungi Kami</h3>

                                <span class="border"></span>

                            </div>

                            <form class="appointment-form" action="#">

                                <div class="input-box">

                                    <input
                                        type="text"
                                        name="form_name"
                                        placeholder="Nama">

                                    <div class="icon-box">

                                        <i
                                            class="fa fa-user"
                                            aria-hidden="true"></i>

                                    </div>

                                </div>

                                <div class="input-box">

                                    <input
                                        type="email"
                                        name="form_email"
                                        placeholder="Email">

                                    <div class="icon-box">

                                        <i
                                            class="fa fa-envelope"
                                            aria-hidden="true"></i>

                                    </div>

                                </div>

                                <div class="input-box">

                                    <textarea
                                        name="form_message"
                                        placeholder="Pesan..."></textarea>

                                </div>

                                <button type="submit">
                                    Kirim
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </footer>
        {{-- END FOOTER --}}

        {{-- FOOTER BOTTOM --}}
        <section class="footer-bottom-area">

            <div class="container">

                <div class="row">

                    <div class="col-md-8">

                        <div class="copyright-text">

                            <p>
                                Copyright © {{ date('Y') }}
                                All Rights Reserved,
                                <a href="{{ route('frontend.home') }}">SIFIT.</a>
                            </p>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <ul class="footer-social-links">

                            <li>
                                <a href="#">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </section>
        {{-- END FOOTER BOTTOM --}}

    </div>

    {{-- SCROLL TO TOP --}}
    <div
        class="scroll-to-top scroll-to-target"
        data-target="html">

        <span class="flaticon-triangle-inside-circle"></span>

    </div>

    {{-- =============================== --}}
    {{-- JAVASCRIPT --}}
    {{-- =============================== --}}

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

    {{-- ASSETS JS --}}
    <script src="{{ asset('frontend/assets/timepicker/timePicker.js') }}"></script>

    <script src="{{ asset('frontend/assets/bootstrap-sl-1.12.1/bootstrap-select.js') }}"></script>

    <script src="{{ asset('frontend/assets/jquery-ui-1.11.4/jquery-ui.js') }}"></script>

    <script src="{{ asset('frontend/assets/language-switcher/jquery.polyglot.language.switcher.js') }}"></script>

    <script src="{{ asset('frontend/assets/html5lightbox/html5lightbox.js') }}"></script>

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

    {{-- CUSTOM --}}
    <script src="{{ asset('frontend/js/custom.js') }}"></script>

    @stack('scripts')

</body>

</html>