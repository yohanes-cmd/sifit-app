@extends('frontend.layouts.app')
@section('title', 'FAQ - SIFIT')

@section('content')
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>FAQ</h1>
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
                            <li><a href="{{ route('frontend.about') }}">Tentang Kami</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active">FAQ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="faq-content-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Pertanyaan yang Sering Diajukan</h1>
            <span class="border"></span>
            <p>Temukan jawaban mengenai penggunaan dan informasi yang tersedia pada SIFIT.</p>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="accordion-box">
                    <div class="accordion accordion-block wow fadeInUp" data-wow-delay="0.2s">
                        <div class="accord-btn active">
                            <h4>Apa itu SIFIT?</h4>
                        </div>
                        <div class="accord-content collapsed">
                            <p>SIFIT adalah Sistem Informasi Farmasi yang menyediakan informasi mengenai data obat dan informasi kefarmasian dalam satu sistem.</p>
                        </div>
                    </div>

                    <div class="accordion accordion-block wow fadeInUp" data-wow-delay="0.3s">
                        <div class="accord-btn">
                            <h4>Informasi apa saja yang tersedia di SIFIT?</h4>
                        </div>
                        <div class="accord-content">
                            <p>SIFIT menyediakan data obat, kategori obat, informasi stok, serta berita dan informasi yang berkaitan dengan farmasi.</p>
                        </div>
                    </div>

                    <div class="accordion accordion-block wow fadeInUp" data-wow-delay="0.4s">
                        <div class="accord-btn">
                            <h4>Bagaimana cara mencari obat?</h4>
                        </div>
                        <div class="accord-content">
                            <p>Buka halaman Data Obat, kemudian gunakan kolom pencarian untuk mencari obat berdasarkan nama yang ingin ditemukan.</p>
                        </div>
                    </div>

                    <div class="accordion accordion-block wow fadeInUp" data-wow-delay="0.5s">
                        <div class="accord-btn">
                            <h4>Apakah data obat dapat dilihat berdasarkan kategori?</h4>
                        </div>
                        <div class="accord-content">
                            <p>Ya. Data obat dapat dikelompokkan berdasarkan kategori sehingga pengguna dapat menemukan obat dengan lebih mudah.</p>
                        </div>
                    </div>

                    <div class="accordion accordion-block wow fadeInUp" data-wow-delay="0.6s">
                        <div class="accord-btn">
                            <h4>Apakah SIFIT menampilkan informasi stok obat?</h4>
                        </div>
                        <div class="accord-content">
                            <p>Ya. Informasi stok ditampilkan berdasarkan data obat yang telah tercatat dan dikelola di dalam sistem.</p>
                        </div>
                    </div>

                    <div class="accordion accordion-block wow fadeInUp" data-wow-delay="0.7s">
                        <div class="accord-btn">
                            <h4>Apakah SIFIT menyediakan berita farmasi?</h4>
                        </div>
                        <div class="accord-content">
                            <p>Ya. SIFIT menyediakan halaman Berita untuk menampilkan informasi dan berita yang berkaitan dengan bidang farmasi.</p>
                        </div>
                    </div>

                    <div class="accordion accordion-block wow fadeInUp" data-wow-delay="0.8s">
                        <div class="accord-btn">
                            <h4>Apakah masyarakat dapat mengakses SIFIT?</h4>
                        </div>
                        <div class="accord-content">
                            <p>Ya. Halaman frontend SIFIT dirancang agar informasi yang tersedia dapat diakses dengan mudah oleh masyarakat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="wow fadeInRight" data-wow-delay="0.4s">
                    <div class="sec-title">
                        <h2>Tentang SIFIT</h2>
                        <span class="border"></span>
                    </div>
                    <div class="text">
                        <p>SIFIT membantu pengguna memperoleh informasi farmasi melalui sistem yang terstruktur dan mudah digunakan.</p>
                        <p>Informasi yang tersedia meliputi data obat, kategori, stok, serta berita farmasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection