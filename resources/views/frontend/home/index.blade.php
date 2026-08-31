@extends('frontend.layouts.app')
@section('title', 'Beranda - SIFIT')

@section('content')
<style>
    .sifit-home-products {
        padding: 45px 0 35px !important;
    }

    .sifit-home-products .sec-title {
        margin-bottom: 20px !important;
    }

    .sifit-home-product-row {
        display: flex;
        flex-wrap: wrap;
    }

    .sifit-home-product-col {
        display: flex;
        margin-bottom: 20px;
    }

    .sifit-home-product-card {
        width: 100%;
        height: 100%;
        margin-bottom: 0 !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .sifit-home-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    .sifit-home-product-card .img-holder {
        width: 100%;
        overflow: hidden;
    }

    .sifit-home-product-card .img-holder > img {
        width: 100% !important;
        height: 200px !important;
        object-fit: contain !important;
        object-position: center !important;
        background: #f7f7f7;
        padding: 8px;
        display: block;
        transition: transform 0.4s ease;
    }

    .sifit-home-product-card:hover .img-holder > img {
        transform: scale(1.03);
    }

    .sifit-home-product-card .text-holder {
        min-height: 85px;
        padding: 12px 10px 15px !important;
        text-align: center;
    }

    .sifit-home-product-card .text-holder h3 {
        min-height: 46px;
        margin: 0 0 4px;
        line-height: 23px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sifit-home-product-card .text-holder span {
        display: block;
        line-height: 21px;
    }

    .sifit-features-area {
        padding: 45px 0 !important;
    }

    .sifit-features-area .sec-title {
        margin-bottom: 20px !important;
    }

    .sifit-feature-item {
        margin-bottom: 18px !important;
        min-height: 125px;
    }

    .sifit-feature-item .text-holder h3 {
        margin-bottom: 6px;
    }

    .sifit-feature-item .text-holder p {
        margin: 0;
        line-height: 23px;
    }

    .sifit-search-box .sec-title {
        margin-bottom: 20px !important;
    }

    .sifit-search-box .input-box {
        margin-bottom: 12px !important;
    }

    @media (max-width: 767px) {
        .sifit-home-products,
        .sifit-features-area {
            padding: 35px 0 !important;
        }

        .sifit-home-product-row {
            display: block;
        }

        .sifit-home-product-col {
            display: block;
        }

        .sifit-home-product-card .img-holder > img {
            height: 230px !important;
        }

        .sifit-home-product-card .text-holder,
        .sifit-home-product-card .text-holder h3 {
            min-height: auto;
        }

        .sifit-feature-item {
            min-height: auto;
        }
    }
</style>

{{-- SLIDER --}}
<section class="rev_slider_wrapper">
    <div id="slider1" class="rev_slider" data-version="5.0">
        <ul>
            <li data-transition="rs-20">
                <img src="{{ asset('frontend/images/slides/1.jpg') }}" alt="SIFIT" width="1920" height="700" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1">
                <div class="tp-caption tp-resizeme" data-x="left" data-hoffset="0" data-y="top" data-voffset="220" data-transform_idle="o:1;" data-transform_in="x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" data-transform_out="s:1000;e:Power3.easeInOut;" data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" data-splitin="none" data-splitout="none" data-responsive_offset="on" data-start="1500">
                    <div class="slide-content-box mar-lft">
                        <h1>Sistem Informasi<br>Farmasi <span>Terintegrasi.</span></h1>
                        <p>Akses informasi obat dan berita kefarmasian<br>secara mudah melalui SIFIT.</p>
                        <div class="button">
                            <a href="{{ route('frontend.about') }}">Tentang SIFIT</a>
                            <a class="btn-style-two" href="{{ route('frontend.obat') }}">Data Obat</a>
                        </div>
                    </div>
                </div>
            </li>

            <li data-transition="fade">
                <img src="{{ asset('frontend/images/slides/2.jpg') }}" alt="Data Obat SIFIT" width="1920" height="700" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1">
                <div class="tp-caption tp-resizeme" data-x="right" data-hoffset="0" data-y="top" data-voffset="220" data-transform_idle="o:1;" data-transform_in="x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" data-transform_out="s:1000;e:Power3.easeInOut;" data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" data-splitin="none" data-splitout="none" data-responsive_offset="on" data-start="1500">
                    <div class="slide-content-box">
                        <h1>Temukan Informasi<br>Obat dengan <span>Mudah.</span></h1>
                        <p>Cari data obat yang telah dipublikasikan<br>melalui Sistem Informasi Farmasi SIFIT.</p>
                        <div class="button">
                            <a href="{{ route('frontend.obat') }}">Cari Obat</a>
                            <a class="btn-style-two" href="{{ route('frontend.berita') }}">Berita</a>
                        </div>
                    </div>
                </div>
            </li>

            <li data-transition="fade">
                <img src="{{ asset('frontend/images/slides/3.jpg') }}" alt="Berita Farmasi SIFIT" width="1920" height="700" data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="1">
                <div class="tp-caption tp-resizeme" data-x="left" data-hoffset="0" data-y="top" data-voffset="220" data-transform_idle="o:1;" data-transform_in="x:[-175%];y:0px;z:0;rX:0;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0.01;s:3000;e:Power3.easeOut;" data-transform_out="s:1000;e:Power3.easeInOut;" data-mask_in="x:[100%];y:0;s:inherit;e:inherit;" data-splitin="none" data-splitout="none" data-responsive_offset="on" data-start="1500">
                    <div class="slide-content-box mar-lft">
                        <h1>Informasi Farmasi<br>Dalam Satu <span>Sistem.</span></h1>
                        <p>Dapatkan berita dan informasi kefarmasian<br>terbaru melalui SIFIT.</p>
                        <div class="button">
                            <a href="{{ route('frontend.berita') }}">Lihat Berita</a>
                            <a class="btn-style-two" href="{{ route('frontend.about') }}">Tentang Kami</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</section>

{{-- PENCARIAN OBAT --}}
<section class="callto-action-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="inner-content">
                    <div class="title-box text-center">
                        <span class="flaticon-calendar"></span>
                        <h2>Cari Informasi Obat</h2>
                    </div>

                    <div class="form-holder clearfix">
                        <form class="clearfix" action="{{ route('frontend.obat') }}" method="GET">
                            <div class="single-box mar-right-30">
                                <div class="input-box">
                                    <input type="text" name="search" placeholder="Masukkan nama obat...">
                                </div>
                                <div class="input-box">
                                    <input type="text" value="Data obat SIFIT" readonly>
                                </div>
                            </div>

                            <div class="single-box">
                                <div class="input-box">
                                    <input type="text" value="Informasi farmasi terintegrasi" readonly>
                                </div>
                                <div class="input-box">
                                    <input type="text" value="Klik tombol untuk mencari obat" readonly>
                                </div>
                            </div>

                            <button class="thm-btn bgclr-1" type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAYANAN SIFIT --}}
<section class="medical-departments-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Layanan SIFIT</h1>
            <span class="border"></span>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="medical-departments-carousel">
                    <div class="single-item text-center">
                        <div class="iocn-holder">
                            <span class="flaticon-cardiology"></span>
                        </div>
                        <div class="text-holder">
                            <h3>Data Obat</h3>
                            <p>Temukan data obat yang telah dipublikasikan melalui Sistem Informasi Farmasi SIFIT.</p>
                        </div>
                        <a class="readmore" href="{{ route('frontend.obat') }}">Lihat Data</a>
                    </div>

                    <div class="single-item text-center">
                        <div class="iocn-holder">
                            <span class="flaticon-lungs"></span>
                        </div>
                        <div class="text-holder">
                            <h3>Pencarian Obat</h3>
                            <p>Cari obat berdasarkan nama agar informasi yang dibutuhkan lebih mudah ditemukan.</p>
                        </div>
                        <a class="readmore" href="{{ route('frontend.obat') }}">Cari Obat</a>
                    </div>

                    <div class="single-item text-center">
                        <div class="iocn-holder">
                            <span class="flaticon-medical"></span>
                        </div>
                        <div class="text-holder">
                            <h3>Informasi Farmasi</h3>
                            <p>Kenali SIFIT dan layanan informasi kefarmasian yang tersedia bagi masyarakat.</p>
                        </div>
                        <a class="readmore" href="{{ route('frontend.about') }}">Selengkapnya</a>
                    </div>

                    <div class="single-item text-center">
                        <div class="iocn-holder">
                            <span class="flaticon-neurology"></span>
                        </div>
                        <div class="text-holder">
                            <h3>Berita Farmasi</h3>
                            <p>Ikuti berita dan informasi terbaru yang telah dipublikasikan melalui SIFIT.</p>
                        </div>
                        <a class="readmore" href="{{ route('frontend.berita') }}">Lihat Berita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG SIFIT --}}
<section class="service-area">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="img-holder">
                    <img src="{{ asset('frontend/images/services/doctor.jpg') }}" alt="SIFIT">
                    <div class="overlay-content">
                        <p>SIFIT membantu masyarakat memperoleh informasi obat dan informasi kefarmasian dalam satu sistem.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="text-holder">
                    <div class="tab-box">
                        <div class="tab-content">
                            <div class="tab-pane active" id="informasi-sifit">
                                <div class="inner-content">
                                    <div class="sec-title">
                                        <h1>Tentang SIFIT</h1>
                                        <span class="border"></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-box">
                                                <h3>Sistem Informasi Farmasi</h3>
                                                <p>SIFIT merupakan Sistem Informasi Farmasi yang menyediakan informasi obat dan informasi kefarmasian secara lebih mudah, cepat, dan terintegrasi.</p>
                                                <a class="thm-btn" href="{{ route('frontend.about') }}">Selengkapnya</a>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="img-box">
                                                <img src="{{ asset('frontend/images/services/service-big-2.jpg') }}" alt="Tentang SIFIT">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="data-obat">
                                <div class="inner-content">
                                    <div class="sec-title">
                                        <h1>Data Obat</h1>
                                        <span class="border"></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-box">
                                                <h3>Informasi Data Obat</h3>
                                                <p>Lihat nama obat, kategori, harga, stok, satuan, dan ketentuan resep berdasarkan data yang dipublikasikan.</p>
                                                <a class="thm-btn" href="{{ route('frontend.obat') }}">Lihat Obat</a>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="img-box">
                                                <img src="{{ asset('frontend/images/services/service-big-1.jpg') }}" alt="Data Obat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="berita-sifit">
                                <div class="inner-content">
                                    <div class="sec-title">
                                        <h1>Berita Farmasi</h1>
                                        <span class="border"></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-box">
                                                <h3>Informasi Terbaru</h3>
                                                <p>Baca berita dan informasi farmasi yang telah dipublikasikan melalui SIFIT.</p>
                                                <a class="thm-btn" href="{{ route('frontend.berita') }}">Lihat Berita</a>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="img-box">
                                                <img src="{{ asset('frontend/images/services/service-big-3.jpg') }}" alt="Berita Farmasi">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="akses-sifit">
                                <div class="inner-content">
                                    <div class="sec-title">
                                        <h1>Akses Informasi</h1>
                                        <span class="border"></span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="text-box">
                                                <h3>Mudah Digunakan</h3>
                                                <p>Navigasi SIFIT dirancang untuk membantu masyarakat menemukan informasi yang dibutuhkan dengan mudah.</p>
                                                <a class="thm-btn" href="{{ route('frontend.about') }}">Tentang Kami</a>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="img-box">
                                                <img src="{{ asset('frontend/images/services/service-big-4.jpg') }}" alt="Akses SIFIT">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs tab-menu">
                            <li class="active">
                                <a href="#informasi-sifit" data-toggle="tab">
                                    <div class="img-holder">
                                        <img src="{{ asset('frontend/images/services/service-small-2.jpg') }}" alt="SIFIT">
                                        <div class="overlay-style-one">
                                            <div class="box">
                                                <div class="content">
                                                    <div class="iocn-holder">
                                                        <span class="flaticon-plus-symbol"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <h3>Tentang SIFIT</h3>
                            </li>

                            <li>
                                <a href="#data-obat" data-toggle="tab">
                                    <div class="img-holder">
                                        <img src="{{ asset('frontend/images/services/service-small-1.jpg') }}" alt="Data Obat">
                                        <div class="overlay-style-one">
                                            <div class="box">
                                                <div class="content">
                                                    <div class="iocn-holder">
                                                        <span class="flaticon-plus-symbol"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <h3>Data Obat</h3>
                            </li>

                            <li>
                                <a href="#berita-sifit" data-toggle="tab">
                                    <div class="img-holder">
                                        <img src="{{ asset('frontend/images/services/service-small-3.jpg') }}" alt="Berita">
                                        <div class="overlay-style-one">
                                            <div class="box">
                                                <div class="content">
                                                    <div class="iocn-holder">
                                                        <span class="flaticon-plus-symbol"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <h3>Berita</h3>
                            </li>

                            <li>
                                <a href="#akses-sifit" data-toggle="tab">
                                    <div class="img-holder">
                                        <img src="{{ asset('frontend/images/services/service-small-4.jpg') }}" alt="Akses Informasi">
                                        <div class="overlay-style-one">
                                            <div class="box">
                                                <div class="content">
                                                    <div class="iocn-holder">
                                                        <span class="flaticon-plus-symbol"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <h3>Informasi</h3>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- DATA OBAT TERBARU --}}
<section class="team-area sifit-home-products">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
            <h1>Data Obat Terbaru</h1>
            <span class="border"></span>
        </div>

        <div class="row sifit-home-product-row">
            @forelse($latestProducts as $product)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 sifit-home-product-col">
                    <div
                        class="single-team-member sifit-home-product-card wow fadeInUp"
                        data-wow-duration="0.8s"
                        data-wow-delay="{{ number_format(0.15 + (($loop->index % 4) * 0.12), 2) }}s"
                    >
                        <div class="img-holder">
                            <img
                                src="{{ $product->image ? asset('storage/'.$product->image) : asset('frontend/images/team/1.jpg') }}"
                                alt="{{ $product->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('frontend/images/team/1.jpg') }}';"
                            >

                            <div class="overlay-style">
                                <div class="box">
                                    <div class="content">
                                        <div class="top">
                                            <h3>{{ $product->name }}</h3>
                                            <span>{{ $product->category ? $product->category->name : 'Obat' }}</span>
                                        </div>

                                        <span class="border"></span>

                                        <div class="bottom">
                                            <ul>
                                                <li>
                                                    <i class="fa fa-cubes" aria-hidden="true"></i>
                                                    Stok: {{ $product->stock }} {{ $product->unit ?? '' }}
                                                </li>
                                                <li>
                                                    <a href="{{ route('frontend.obat.detail', $product->slug) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                        Lihat Detail
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-holder">
                                <h3>
                                    <a href="{{ route('frontend.obat.detail', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <span>{{ $product->category ? $product->category->name : 'Obat' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p>Belum ada data obat yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- INFORMASI SIFIT --}}
<section class="fact-counter-area" style="background-image: url('/frontend/images/resources/fact-counter-bg.jpg');">
    <div class="container">
        <div class="sec-title text-center">
            <h1>Informasi Farmasi Lebih Mudah Bersama SIFIT</h1>
            <p>Akses data obat dan berita kefarmasian melalui satu sistem informasi yang mudah digunakan.</p>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul>
                    <li>
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-medical"></span>
                            </div>
                            <h1>
                                <span class="timer" data-from="0" data-to="{{ $latestProducts->count() }}" data-speed="1500" data-refresh-interval="50">
                                    {{ $latestProducts->count() }}
                                </span>
                            </h1>
                            <h3>Obat Terbaru</h3>
                        </div>
                    </li>

                    <li>
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-smile"></span>
                            </div>
                            <h1>
                                <span class="timer" data-from="0" data-to="{{ $latestNews->count() }}" data-speed="1500" data-refresh-interval="50">
                                    {{ $latestNews->count() }}
                                </span>
                            </h1>
                            <h3>Berita Terbaru</h3>
                        </div>
                    </li>

                    <li>
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-medical-1"></span>
                            </div>
                            <h1>
                                <span class="timer" data-from="0" data-to="1" data-speed="1500" data-refresh-interval="50">1</span>
                            </h1>
                            <h3>Sistem Terintegrasi</h3>
                        </div>
                    </li>

                    <li>
                        <div class="single-item text-center">
                            <div class="icon-holder">
                                <span class="flaticon-ribbon"></span>
                            </div>
                            <h1>
                                <span class="timer" data-from="0" data-to="3" data-speed="1500" data-refresh-interval="50">3</span>
                            </h1>
                            <h3>Layanan Informasi</h3>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KEUNGGULAN --}}
<section class="testimonial-area">
    <div class="container">
        <div class="sec-title mar0auto text-center">
            <h1>Mengapa Menggunakan SIFIT?</h1>
            <span class="border"></span>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="testimonial-carousel">
                    <div class="single-testimonial-item text-center">
                        <div class="img-box">
                            <div class="img-holder">
                                <img src="{{ asset('frontend/images/testimonial/1.png') }}" alt="Informasi Obat">
                            </div>
                            <div class="quote-box">
                                <i class="fa fa-info" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="text-holder">
                            <p>Informasi obat ditampilkan berdasarkan data yang telah dipublikasikan melalui sistem.</p>
                        </div>
                        <div class="name">
                            <h3>Informasi Obat</h3>
                            <span>SIFIT</span>
                        </div>
                    </div>

                    <div class="single-testimonial-item text-center">
                        <div class="img-box">
                            <div class="img-holder">
                                <img src="{{ asset('frontend/images/testimonial/2.png') }}" alt="Pencarian">
                            </div>
                            <div class="quote-box">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="text-holder">
                            <p>Pencarian membantu masyarakat menemukan data obat yang dibutuhkan dengan lebih cepat.</p>
                        </div>
                        <div class="name">
                            <h3>Mudah Dicari</h3>
                            <span>SIFIT</span>
                        </div>
                    </div>

                    <div class="single-testimonial-item text-center">
                        <div class="img-box">
                            <div class="img-holder">
                                <img src="{{ asset('frontend/images/testimonial/1.png') }}" alt="Berita">
                            </div>
                            <div class="quote-box">
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="text-holder">
                            <p>Berita kefarmasian terbaru dapat diakses melalui halaman berita SIFIT.</p>
                        </div>
                        <div class="name">
                            <h3>Berita Farmasi</h3>
                            <span>SIFIT</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
<section class="latest-blog-area">
    <div class="container">
        <div class="sec-title">
            <h1>Berita Terbaru</h1>
            <span class="border"></span>
        </div>

        <div class="row">
            @forelse($latestNews as $item)
                <div class="col-md-4">
                    <div class="single-blog-item">
                        <div class="img-holder">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
                            @else
                                <img src="{{ asset('frontend/images/blog/latest-blog-1.jpg') }}" alt="{{ $item->title }}">
                            @endif

                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.berita.detail', $item->slug) }}">
                                            <span class="flaticon-plus-symbol"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-holder">
                            <a href="{{ route('frontend.berita.detail', $item->slug) }}">
                                <h3 class="blog-title">{{ $item->title }}</h3>
                            </a>

                            <div class="text">
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}</p>
                            </div>

                            <ul class="meta-info">
                                <li>
                                    <a href="{{ route('frontend.berita.detail', $item->slug) }}">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : $item->created_at->format('d M Y') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('frontend.berita.detail', $item->slug) }}">
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        {{ $item->category ? $item->category->name : 'Berita' }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p>Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- FITUR DAN PENCARIAN --}}
<section class="facilities-appointment-area sifit-features-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="facilities-content-box wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="sec-title">
                        <h1>Fitur SIFIT</h1>
                        <span class="border"></span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="single-item sifit-feature-item">
                                <div class="icon-holder">
                                    <div class="icon-box">
                                        <div class="icon">
                                            <span class="flaticon-transport"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-holder">
                                    <h3>Data Obat</h3>
                                    <p>Menampilkan data obat yang telah dipublikasikan melalui SIFIT.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="single-item sifit-feature-item">
                                <div class="icon-holder">
                                    <div class="icon-box">
                                        <div class="icon">
                                            <span class="flaticon-drink"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-holder">
                                    <h3>Kategori Obat</h3>
                                    <p>Membantu pengguna melihat obat berdasarkan kategori yang tersedia.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="single-item sifit-feature-item">
                                <div class="icon-holder">
                                    <div class="icon-box">
                                        <div class="icon">
                                            <span class="flaticon-avatar"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-holder">
                                    <h3>Berita Farmasi</h3>
                                    <p>Menyediakan berita dan informasi kefarmasian melalui SIFIT.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="single-item sifit-feature-item">
                                <div class="icon-holder">
                                    <div class="icon-box">
                                        <div class="icon">
                                            <span class="flaticon-church"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-holder">
                                    <h3>Informasi SIFIT</h3>
                                    <p>Menampilkan informasi mengenai SIFIT, visi misi, fitur, FAQ, dan galeri.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="appointment sifit-search-box wow fadeInRight" data-wow-duration="0.8s" data-wow-delay="0.2s">
                    <div class="sec-title">
                        <h1>Cari Obat</h1>
                        <span class="border"></span>
                    </div>

                    <form action="{{ route('frontend.obat') }}" method="GET">
                        <div class="input-box">
                            <input type="text" name="search" placeholder="Masukkan nama obat..." required>
                        </div>

                        <button class="thm-btn bgclr-1" type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Cari Obat
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- PENUTUP --}}
<section class="brand-area" style="background-image: url('/frontend/images/awards/awards-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="text-holder">
                    <div class="sec-title">
                        <h1>Informasi Farmasi dalam Satu Sistem</h1>
                    </div>

                    <div class="text">
                        <p>SIFIT membantu menyediakan informasi obat dan informasi kefarmasian yang dapat diakses masyarakat secara lebih mudah.</p>
                        <p>Temukan data obat dan ikuti berita terbaru melalui Sistem Informasi Farmasi Terintegrasi.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="awards-holder">
                    <div class="sec-title">
                        <h1>Akses Informasi</h1>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="single-item">
                                <a href="{{ route('frontend.obat') }}">
                                    <img src="{{ asset('frontend/images/awards/1.png') }}" alt="Data Obat">
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="single-item">
                                <a href="{{ route('frontend.berita') }}">
                                    <img src="{{ asset('frontend/images/awards/2.png') }}" alt="Berita SIFIT">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection