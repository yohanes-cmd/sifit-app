@extends('frontend.layouts.app')
@section('title', 'Tentang Kami - SIFIT')

@section('content')
{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>Tentang Kami</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="breadcrumb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="left pull-left">
                        <ul>
                            <li><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active">Tentang Kami</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- WELCOME AREA --}}
<section class="welcome-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="img-holder wow fadeInLeft" data-wow-delay="0.3s">
                    <img src="{{ asset('frontend/images/resources/welcome.jpg') }}" alt="Tentang SIFIT">
                </div>
                <div class="inner-content wow fadeInUp" data-wow-delay="0.4s">
                    <p>SIFIT hadir sebagai Sistem Informasi Farmasi yang membantu masyarakat memperoleh informasi obat dan layanan kefarmasian secara mudah, cepat, dan terpercaya.</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="text-holder wow fadeInRight" data-wow-delay="0.3s">
                    <div class="title">
                        <h1>Selamat Datang di SIFIT</h1>
                        <p>SIFIT merupakan platform informasi farmasi yang menyediakan berbagai informasi terkait obat, berita kefarmasian, dan informasi pendukung lainnya bagi masyarakat.</p>
                    </div>

                    <ul>
                        <li>
                            <div class="single-item">
                                <div class="iocn-box">
                                    <span class="flaticon-shapes"></span>
                                </div>
                                <div class="text-box">
                                    <h3>Misi Kami</h3>
                                    <p>Menyediakan informasi obat dan layanan kefarmasian yang mudah diakses, informatif, dan bermanfaat bagi masyarakat.</p>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="single-item">
                                <div class="iocn-box">
                                    <span class="flaticon-technology-2"></span>
                                </div>
                                <div class="text-box">
                                    <h3>Visi Kami</h3>
                                    <p>Menjadi Sistem Informasi Farmasi yang terpercaya dan mendukung kemudahan akses informasi kefarmasian.</p>

                                    <div class="text">
                                        <p><i class="fa fa-hand-o-right"></i> Memberikan akses informasi obat secara mudah.</p>
                                        <p><i class="fa fa-hand-o-right"></i> Mendukung penyebaran informasi kefarmasian secara digital.</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="button">
                        <a class="thm-btn bgclr-1" href="{{ route('frontend.obat') }}">
                            Lihat Data Obat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SPECIAL FEATURES --}}
<section class="special-features-area">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="single-item wow fadeInUp" data-wow-delay="0.2s">
                    <div class="icon-box">
                        <span class="flaticon-transport"></span>
                    </div>
                    <div class="text-box">
                        <h3>Informasi Obat</h3>
                        <p>SIFIT menyediakan informasi mengenai berbagai obat yang dapat diakses masyarakat dengan lebih mudah.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-item wow fadeInUp" data-wow-delay="0.4s">
                    <div class="icon-box">
                        <span class="flaticon-drink"></span>
                    </div>
                    <div class="text-box">
                        <h3>Data Obat Terintegrasi</h3>
                        <p>Data obat ditampilkan secara terstruktur sehingga pengguna lebih mudah menemukan informasi yang dibutuhkan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-item wow fadeInUp" data-wow-delay="0.6s">
                    <div class="icon-box">
                        <span class="flaticon-avatar"></span>
                    </div>
                    <div class="text-box">
                        <h3>Informasi Kefarmasian</h3>
                        <p>Berbagai informasi terkait dunia kefarmasian tersedia sebagai sumber informasi bagi masyarakat.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="single-item wow fadeInUp" data-wow-delay="0.2s">
                    <div class="icon-box">
                        <span class="flaticon-church"></span>
                    </div>
                    <div class="text-box">
                        <h3>Akses Mudah</h3>
                        <p>Informasi dapat diakses melalui website SIFIT menggunakan perangkat yang terhubung dengan internet.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-item wow fadeInUp" data-wow-delay="0.4s">
                    <div class="icon-box">
                        <span class="flaticon-phone"></span>
                    </div>
                    <div class="text-box">
                        <h3>Informasi Terpercaya</h3>
                        <p>Informasi disajikan secara jelas dan terstruktur untuk membantu pengguna memperoleh informasi yang dibutuhkan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="single-item wow fadeInUp" data-wow-delay="0.6s">
                    <div class="icon-box">
                        <span class="flaticon-medical-2"></span>
                    </div>
                    <div class="text-box">
                        <h3>Layanan Informasi</h3>
                        <p>SIFIT membantu masyarakat memperoleh informasi obat dan informasi kefarmasian dalam satu sistem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SLOGAN --}}
<section class="slogan-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="title pull-left wow fadeInLeft" data-wow-delay="0.2s">
                    <h2>Dapatkan informasi obat yang mudah, cepat, dan terpercaya melalui SIFIT.</h2>
                </div>

                <div class="button pull-right wow fadeInRight" data-wow-delay="0.2s">
                    <a class="thm-btn bgclr-1" href="{{ route('frontend.obat') }}">
                        Lihat Data Obat
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- GALLERY & FAQ --}}
<section class="project-faq-area sec-padding">
    <div class="container">
        <div class="sec-title mar0auto text-center wow fadeInUp" data-wow-delay="0.2s">
            <h1>Informasi & Pertanyaan Umum</h1>
            <span class="border"></span>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="latest-project wow fadeInLeft" data-wow-delay="0.3s">

                    <div class="single-project-item">
                        <div class="img-holder">
                            <img src="{{ asset('frontend/images/projects/latest-project-1.jpg') }}" alt="Informasi SIFIT">
                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.about.galeri') }}">
                                            <i class="fa fa-link" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="single-project-item">
                        <div class="img-holder">
                            <img src="{{ asset('frontend/images/projects/latest-project-2.jpg') }}" alt="Informasi SIFIT">
                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.about.galeri') }}">
                                            <i class="fa fa-link" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="single-project-item">
                        <div class="img-holder">
                            <img src="{{ asset('frontend/images/projects/latest-project-3.jpg') }}" alt="Informasi SIFIT">
                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.about.galeri') }}">
                                            <i class="fa fa-link" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="single-project-item">
                        <div class="img-holder">
                            <img src="{{ asset('frontend/images/projects/latest-project-4.jpg') }}" alt="Informasi SIFIT">
                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.about.galeri') }}">
                                            <i class="fa fa-link" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="single-project-item">
                        <div class="img-holder">
                            <img src="{{ asset('frontend/images/projects/latest-project-5.jpg') }}" alt="Informasi SIFIT">
                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.about.galeri') }}">
                                            <i class="fa fa-link" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="single-project-item">
                        <div class="img-holder">
                            <img src="{{ asset('frontend/images/projects/latest-project-6.jpg') }}" alt="Informasi SIFIT">
                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.about.galeri') }}">
                                            <i class="fa fa-link" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <div class="faq-content wow fadeInRight" data-wow-delay="0.3s">
                    <div class="accordion-box">

                        <div class="accordion accordion-block">
                            <div class="accord-btn">
                                <h4>Apa itu SIFIT?</h4>
                            </div>
                            <div class="accord-content">
                                <p>SIFIT adalah Sistem Informasi Farmasi yang menyediakan informasi mengenai obat dan informasi kefarmasian untuk membantu masyarakat memperoleh informasi dengan lebih mudah.</p>
                            </div>
                        </div>

                        <div class="accordion accordion-block">
                            <div class="accord-btn active">
                                <h4>Informasi apa saja yang tersedia di SIFIT?</h4>
                            </div>
                            <div class="accord-content collapsed">
                                <p>SIFIT menyediakan informasi data obat, berita kefarmasian, serta berbagai informasi pendukung terkait layanan farmasi.</p>
                            </div>
                        </div>

                        <div class="accordion accordion-block">
                            <div class="accord-btn">
                                <h4>Apakah masyarakat dapat melihat data obat?</h4>
                            </div>
                            <div class="accord-content">
                                <p>Ya. Pengguna dapat membuka menu Data Obat untuk melihat informasi obat yang tersedia pada SIFIT.</p>
                            </div>
                        </div>

                        <div class="accordion accordion-block last">
                            <div class="accord-btn last">
                                <h4>Bagaimana cara mencari informasi obat?</h4>
                            </div>
                            <div class="accord-content">
                                <p>Buka halaman Data Obat kemudian gunakan fitur pencarian untuk menemukan informasi obat yang dibutuhkan.</p>
                            </div>
                        </div>

                    </div>

                    <div style="margin-top: 30px;">
                        <a href="{{ route('frontend.about.faq') }}" class="thm-btn bgclr-1">
                            Lihat Semua FAQ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FACT COUNTER --}}
<section class="fact-counter-area black-bg" style="background-image: url('/frontend/images/resources/fact-counter-bg-v2.jpg');">
    <div class="container">
        <div class="sec-title text-center wow fadeInUp" data-wow-delay="0.2s">
            <h1>Informasi <span>Farmasi</span> dalam Satu Sistem</h1>
            <p>SIFIT menampilkan data berdasarkan informasi yang telah tersedia dan dipublikasikan pada sistem.</p>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul>
                    <li class="wow fadeInUp" data-wow-delay="0.2s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-medical"></span>
                            </div>
                            <h1>
                                <span class="timer"
                                    data-from="0"
                                    data-to="{{ $totalProducts }}"
                                    data-speed="2000"
                                    data-refresh-interval="50">
                                    {{ $totalProducts }}
                                </span>
                            </h1>
                            <h3>Data Obat</h3>
                        </div>
                    </li>

                    <li class="wow fadeInUp" data-wow-delay="0.4s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-smile"></span>
                            </div>
                            <h1>
                                <span class="timer"
                                    data-from="0"
                                    data-to="{{ $totalNews }}"
                                    data-speed="2000"
                                    data-refresh-interval="50">
                                    {{ $totalNews }}
                                </span>
                            </h1>
                            <h3>Berita Farmasi</h3>
                        </div>
                    </li>

                    <li class="wow fadeInUp" data-wow-delay="0.6s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-medical-1"></span>
                            </div>
                            <h1>
                                <span class="timer"
                                    data-from="0"
                                    data-to="{{ $totalCategories }}"
                                    data-speed="2000"
                                    data-refresh-interval="50">
                                    {{ $totalCategories }}
                                </span>
                            </h1>
                            <h3>Kategori Obat</h3>
                        </div>
                    </li>

                    <li class="wow fadeInUp" data-wow-delay="0.8s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-ribbon"></span>
                            </div>
                            <h1>
                                <span class="timer"
                                    data-from="0"
                                    data-to="{{ $totalPublishedInfo }}"
                                    data-speed="2000"
                                    data-refresh-interval="50">
                                    {{ $totalPublishedInfo }}
                                </span>
                            </h1>
                            <h3>Informasi Dipublikasikan</h3>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- TEAM --}}
<section class="team-area doctor">
    <div class="container">
        <div class="sec-title mar0auto text-center wow fadeInUp" data-wow-delay="0.2s">
            <h1>Tim Pengelola SIFIT</h1>
            <span class="border"></span>
        </div>

        <div class="row">

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-team-member wow fadeInUp" data-wow-delay="0.2s">
                    <div class="img-holder">
                        <img src="{{ asset('frontend/images/team/1.jpg') }}" alt="Tim SIFIT">

                        <div class="overlay-style">
                            <div class="box">
                                <div class="content">
                                    <div class="top">
                                        <h3>Tim SIFIT</h3>
                                        <span>Pengelola Sistem</span>
                                    </div>

                                    <span class="border"></span>

                                    <div class="bottom">
                                        <ul>
                                            <li>
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                info@sifit.id
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-holder">
                            <h3>Tim SIFIT</h3>
                            <span>Pengelola Sistem</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-team-member wow fadeInUp" data-wow-delay="0.4s">
                    <div class="img-holder">
                        <img src="{{ asset('frontend/images/team/2.jpg') }}" alt="Admin SIFIT">

                        <div class="overlay-style">
                            <div class="box">
                                <div class="content">
                                    <div class="top">
                                        <h3>Admin SIFIT</h3>
                                        <span>Pengelola Data</span>
                                    </div>

                                    <span class="border"></span>

                                    <div class="bottom">
                                        <ul>
                                            <li>
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                info@sifit.id
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-holder">
                            <h3>Admin SIFIT</h3>
                            <span>Pengelola Data</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-team-member wow fadeInUp" data-wow-delay="0.6s">
                    <div class="img-holder">
                        <img src="{{ asset('frontend/images/team/3.jpg') }}" alt="Tim Informasi SIFIT">

                        <div class="overlay-style">
                            <div class="box">
                                <div class="content">
                                    <div class="top">
                                        <h3>Tim Informasi</h3>
                                        <span>Informasi Farmasi</span>
                                    </div>

                                    <span class="border"></span>

                                    <div class="bottom">
                                        <ul>
                                            <li>
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                info@sifit.id
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-holder">
                            <h3>Tim Informasi</h3>
                            <span>Informasi Farmasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="single-team-member wow fadeInUp" data-wow-delay="0.8s">
                    <div class="img-holder">
                        <img src="{{ asset('frontend/images/team/4.jpg') }}" alt="Tim Layanan SIFIT">

                        <div class="overlay-style">
                            <div class="box">
                                <div class="content">
                                    <div class="top">
                                        <h3>Tim Layanan</h3>
                                        <span>Layanan Informasi</span>
                                    </div>

                                    <span class="border"></span>

                                    <div class="bottom">
                                        <ul>
                                            <li>
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                info@sifit.id
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-holder">
                            <h3>Tim Layanan</h3>
                            <span>Layanan Informasi</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- CERTIFICATES --}}
<section class="certificates-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Mitra & Informasi Pendukung</h1>
            <span class="border"></span>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="certificates">

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/1.jpg') }}" alt="Mitra SIFIT">
                    </div>

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/2.jpg') }}" alt="Mitra SIFIT">
                    </div>

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/3.jpg') }}" alt="Mitra SIFIT">
                    </div>

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/4.jpg') }}" alt="Mitra SIFIT">
                    </div>

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/1.jpg') }}" alt="Mitra SIFIT">
                    </div>

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/2.jpg') }}" alt="Mitra SIFIT">
                    </div>

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/3.jpg') }}" alt="Mitra SIFIT">
                    </div>

                    <div class="single-item">
                        <img src="{{ asset('frontend/images/certificates/4.jpg') }}" alt="Mitra SIFIT">
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection