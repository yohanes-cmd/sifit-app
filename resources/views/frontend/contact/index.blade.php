@extends('frontend.layouts.app')
@section('title', 'Kontak - SIFIT')

@section('content')
{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>Kontak</h1>
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
                            <li class="active">Kontak</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CONTACT FORM AREA --}}
<section class="contact-form-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Hubungi Kami</h1>
            <span class="border"></span>
        </div>

        <div class="row">
            {{-- FORM --}}
            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                <div class="contact-form wow fadeInLeft" data-wow-delay="0.3s">
                    <form class="default-form" onsubmit="return false;">
                        <h2>Kirim Pesan</h2>

                        <div class="row">
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    name="name"
                                    placeholder="Nama Anda*"
                                >
                            </div>

                            <div class="col-md-6">
                                <input
                                    type="email"
                                    name="email"
                                    placeholder="Email Anda*"
                                >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <input
                                    type="text"
                                    name="phone"
                                    placeholder="Nomor Telepon"
                                >
                            </div>

                            <div class="col-md-6">
                                <input
                                    type="text"
                                    name="subject"
                                    placeholder="Subjek"
                                >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <textarea
                                    name="message"
                                    placeholder="Pesan Anda..."
                                ></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button
                                    class="thm-btn bgclr-1"
                                    type="button"
                                >
                                    Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- QUICK CONTACT --}}
            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                <div class="quick-contact wow fadeInRight" data-wow-delay="0.3s">
                    <div class="title">
                        <h2>Kontak Cepat</h2>
                        <p>
                            Jika Anda memiliki pertanyaan mengenai SIFIT,
                            silakan gunakan informasi kontak berikut.
                        </p>
                    </div>

                    <ul class="contact-info">
                        <li>
                            <div class="icon-holder">
                                <span class="flaticon-pin"></span>
                            </div>
                            <div class="text-holder">
                                <h5>
                                    <span>Alamat:</span>
                                    Informasi alamat pengelola SIFIT
                                </h5>
                            </div>
                        </li>

                        <li>
                            <div class="icon-holder">
                                <span class="flaticon-technology"></span>
                            </div>
                            <div class="text-holder">
                                <h5>
                                    <span>Telepon:</span>
                                    Informasi nomor telepon SIFIT
                                </h5>
                            </div>
                        </li>

                        <li>
                            <div class="icon-holder">
                                <span class="flaticon-interface"></span>
                            </div>
                            <div class="text-holder">
                                <h5>
                                    <span>Email:</span>
                                    info@sifit.id
                                </h5>
                            </div>
                        </li>
                    </ul>

                    <ul class="social-links">
                        <li>
                            <a href="#">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MAP AREA --}}
<section class="contact-map-area">
    <div class="container-fluid">
        <div class="google-map-inner">
            <div
                style="
                    width: 100%;
                    height: 420px;
                    background: #f3f3f3;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                "
            >
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <span
                        class="flaticon-pin"
                        style="font-size: 45px;"
                    ></span>

                    <h3 style="margin-top: 15px;">
                        Lokasi Pengelola SIFIT
                    </h3>

                    <p style="margin-top: 10px;">
                        Peta lokasi dapat ditampilkan pada bagian ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection