@extends('frontend.layouts.app')
@section('title', 'Visi & Misi - SIFIT')

@section('content')
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>Visi & Misi</h1>
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
                            <li class="active">Visi & Misi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="welcome-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Visi & Misi SIFIT</h1>
            <span class="border"></span>
            <p>Arah dan tujuan Sistem Informasi Farmasi dalam menyediakan informasi farmasi kepada masyarakat.</p>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="img-holder wow fadeInLeft" data-wow-delay="0.3s">
                    <img src="{{ asset('frontend/images/resources/welcome.jpg') }}" alt="Visi dan Misi SIFIT">
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="text-holder wow fadeInRight" data-wow-delay="0.3s">
                    <div class="title">
                        <h1>Visi</h1>
                    </div>
                    <div class="text">
                        <p>Menjadi sistem informasi farmasi yang terintegrasi, mudah diakses, dan mampu mendukung penyampaian informasi obat serta informasi kefarmasian kepada masyarakat.</p>
                    </div>
                    <div class="title" style="margin-top: 30px;">
                        <h1>Misi</h1>
                    </div>
                    <div class="text">
                        <ul>
                            <li class="wow fadeInUp" data-wow-delay="0.3s">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Menyediakan informasi obat yang tersusun secara jelas dan mudah diakses.
                            </li>
                            <li class="wow fadeInUp" data-wow-delay="0.4s">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Mempermudah masyarakat dalam mencari informasi obat melalui sistem yang terintegrasi.
                            </li>
                            <li class="wow fadeInUp" data-wow-delay="0.5s">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Menyediakan berita dan informasi kefarmasian melalui SIFIT.
                            </li>
                            <li class="wow fadeInUp" data-wow-delay="0.6s">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Mendukung pengelolaan informasi farmasi secara lebih terstruktur dan efisien.
                            </li>
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
            <h1>Tujuan SIFIT</h1>
            <span class="border"></span>
            <p>SIFIT dikembangkan untuk membantu masyarakat memperoleh informasi farmasi melalui sistem yang mudah digunakan.</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.2s">
                    <div class="iocn-holder">
                        <span class="flaticon-medical"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Informasi Obat</h3>
                        <p>Mempermudah pengguna memperoleh informasi mengenai data obat yang tersedia di SIFIT.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.4s">
                    <div class="iocn-holder">
                        <span class="flaticon-technology"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Akses Mudah</h3>
                        <p>Menyediakan akses informasi melalui sistem yang mudah digunakan oleh masyarakat.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.6s">
                    <div class="iocn-holder">
                        <span class="flaticon-agenda"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Informasi Terintegrasi</h3>
                        <p>Menggabungkan data obat dan berita kefarmasian dalam satu sistem informasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="fact-counter-area" style="background-image: url('/frontend/images/resources/fact-counter-bg-v2.jpg');">
    <div class="container">
        <div class="sec-title text-center wow fadeInUp" data-wow-delay="0.2s">
            <h1>Informasi Farmasi Lebih Mudah Bersama SIFIT</h1>
            <p>Satu sistem untuk membantu masyarakat mengakses informasi obat dan informasi kefarmasian.</p>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul>
                    <li class="wow fadeInUp" data-wow-delay="0.2s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-medical"></span>
                            </div>
                            <h1>01</h1>
                            <h3>Data Obat</h3>
                        </div>
                    </li>
                    <li class="wow fadeInUp" data-wow-delay="0.4s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-technology"></span>
                            </div>
                            <h1>02</h1>
                            <h3>Akses Mudah</h3>
                        </div>
                    </li>
                    <li class="wow fadeInUp" data-wow-delay="0.6s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-agenda"></span>
                            </div>
                            <h1>03</h1>
                            <h3>Berita Farmasi</h3>
                        </div>
                    </li>
                    <li class="wow fadeInUp" data-wow-delay="0.8s">
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-ribbon"></span>
                            </div>
                            <h1>04</h1>
                            <h3>Sistem Terintegrasi</h3>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection