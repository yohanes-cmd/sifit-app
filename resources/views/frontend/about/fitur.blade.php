@extends('frontend.layouts.app')
@section('title', 'Fitur SIFIT - SIFIT')

@section('content')
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>Fitur SIFIT</h1>
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
                            <li class="active">Fitur SIFIT</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="medical-departments-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Fitur Utama SIFIT</h1>
            <span class="border"></span>
            <p>SIFIT menyediakan berbagai fitur untuk membantu masyarakat memperoleh informasi farmasi dengan lebih mudah dan terintegrasi.</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="iocn-holder">
                        <span class="flaticon-medical"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Data Obat</h3>
                        <p>Menampilkan informasi obat yang tersedia di dalam sistem secara terstruktur dan mudah dipahami.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.4s">
                    <div class="iocn-holder">
                        <span class="flaticon-agenda"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Kategori Obat</h3>
                        <p>Mengelompokkan data obat berdasarkan kategori sehingga pengguna lebih mudah menemukan informasi yang dibutuhkan.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.6s">
                    <div class="iocn-holder">
                        <span class="flaticon-technology"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Pencarian Obat</h3>
                        <p>Mempermudah pengguna mencari data obat berdasarkan nama melalui fitur pencarian yang tersedia.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="iocn-holder">
                        <span class="flaticon-plus-symbol"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Informasi Stok</h3>
                        <p>Memberikan informasi mengenai ketersediaan stok obat yang tercatat di dalam sistem SIFIT.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.4s">
                    <div class="iocn-holder">
                        <span class="flaticon-ribbon"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Berita Farmasi</h3>
                        <p>Menyediakan berita dan informasi terbaru yang berkaitan dengan bidang farmasi.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.6s">
                    <div class="iocn-holder">
                        <span class="flaticon-smile"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Akses Mudah</h3>
                        <p>Menyajikan informasi melalui tampilan yang sederhana sehingga lebih mudah digunakan oleh masyarakat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Kemudahan Menggunakan SIFIT</h1>
            <span class="border"></span>
            <p>Fitur-fitur SIFIT dirancang untuk membantu pengguna menemukan informasi farmasi secara lebih cepat dan terarah.</p>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="img-holder wow fadeInLeft" data-wow-delay="0.3s">
                    <img src="{{ asset('frontend/images/resources/service.jpg') }}" alt="Fitur SIFIT">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="text-holder wow fadeInRight" data-wow-delay="0.3s">
                    <div class="title">
                        <h2>Informasi dalam Satu Sistem</h2>
                    </div>
                    <div class="text">
                        <p>SIFIT menggabungkan data obat dan informasi farmasi dalam satu sistem sehingga pengguna tidak perlu mencari informasi melalui banyak halaman yang berbeda.</p>
                        <p>Pengguna dapat mencari data obat, melihat kategori, mengetahui informasi stok, serta membaca berita farmasi melalui layanan yang tersedia.</p>
                    </div>
                    <ul>
                        <li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Informasi obat lebih terstruktur.
                        </li>
                        <li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Pencarian data lebih mudah.
                        </li>
                        <li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Informasi farmasi tersedia dalam satu sistem.
                        </li>
                        <li>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            Tampilan mudah digunakan oleh pengguna.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection