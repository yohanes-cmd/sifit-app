@extends('frontend.layouts.app')
@section('title', 'Informasi Obat - SIFIT')

@section('content')
<style>
    .sifit-info-intro {
        padding: 60px 0;
    }

    .sifit-info-intro .sec-title {
        margin-bottom: 35px;
    }

    .sifit-info-intro .img-holder img {
        width: 100%;
        display: block;
    }

    .sifit-info-intro .text-holder {
        padding-left: 20px;
    }

    .sifit-info-intro .text-holder h2 {
        margin-bottom: 15px;
    }

    .sifit-info-intro .text-holder p {
        line-height: 27px;
        margin-bottom: 14px;
    }

    .sifit-information-area {
        padding: 60px 0 40px;
    }

    .sifit-information-area .sec-title {
        margin-bottom: 35px;
    }

    .sifit-information-card {
        margin-bottom: 25px;
        min-height: 220px;
    }

    .sifit-information-card .text-holder {
        padding: 20px 15px;
    }

    .sifit-information-card .text-holder h3 {
        margin-bottom: 10px;
    }

    .sifit-information-card .text-holder p {
        line-height: 25px;
        margin: 0;
    }

    .sifit-guide-area {
        padding: 60px 0 70px;
    }

    .sifit-guide-area .sec-title {
        margin-bottom: 20px;
    }

    .sifit-guide-area p {
        line-height: 27px;
        margin-bottom: 15px;
    }

    .sifit-guide-list {
        margin-top: 20px;
    }

    .sifit-guide-list li {
        margin-bottom: 12px;
        line-height: 25px;
    }

    .sifit-guide-list li i {
        margin-right: 8px;
    }

    .sifit-warning-box {
        padding-left: 25px;
    }

    @media (max-width: 991px) {
        .sifit-info-intro .text-holder {
            padding-left: 0;
            margin-top: 30px;
        }

        .sifit-warning-box {
            padding-left: 0;
            margin-top: 40px;
        }
    }

    @media (max-width: 767px) {
        .sifit-info-intro,
        .sifit-information-area,
        .sifit-guide-area {
            padding: 45px 0;
        }

        .sifit-information-card {
            min-height: auto;
        }
    }
</style>

{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>Informasi Obat</h1>
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
                            <li><a href="{{ route('frontend.obat') }}">Data Obat</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active">Informasi Obat</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- INTRO --}}
<section class="welcome-area sifit-info-intro">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Informasi Obat di SIFIT</h1>
            <span class="border"></span>
            <p>
                SIFIT menyediakan informasi obat untuk membantu masyarakat
                memperoleh data obat secara lebih mudah dan terstruktur.
            </p>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="img-holder wow fadeInLeft" data-wow-delay="0.3s">
                    <img
                        src="{{ asset('frontend/images/resources/welcome.jpg') }}"
                        alt="Informasi Obat SIFIT"
                        class="img-responsive"
                    >
                </div>
            </div>

            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="text-holder wow fadeInRight" data-wow-delay="0.3s">
                    <h2>Tentang Informasi Obat</h2>

                    <p>
                        Informasi obat pada SIFIT menampilkan data obat yang
                        telah tersedia di dalam sistem seperti nama obat,
                        kategori, kegunaan, harga, stok, satuan, dan ketentuan resep.
                    </p>

                    <p>
                        Kegunaan obat memberikan informasi singkat mengenai
                        fungsi atau penggunaan umum obat berdasarkan data yang
                        telah dimasukkan oleh pengelola SIFIT.
                    </p>

                    <p>
                        Untuk melihat informasi masing-masing obat secara lebih
                        lengkap, pengguna dapat membuka halaman Data Obat kemudian
                        memilih tombol Lihat Detail.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- INFORMASI YANG TERSEDIA --}}
<section class="medical-departments-area sifit-information-area">
    <div class="container">
        <div class="sec-title mar0auto text-center wow fadeInUp" data-wow-delay="0.2s">
            <h1>Informasi yang Tersedia</h1>
            <span class="border"></span>
            <p>
                Informasi utama yang dapat dilihat melalui data obat pada SIFIT.
            </p>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.2s">
                    <div class="iocn-holder">
                        <span class="flaticon-medical"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Nama Obat</h3>
                        <p>
                            Menampilkan nama obat yang telah tercatat
                            dan dipublikasikan di dalam sistem.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.3s">
                    <div class="iocn-holder">
                        <span class="flaticon-agenda"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Kategori Obat</h3>
                        <p>
                            Mengelompokkan obat berdasarkan kategori
                            agar informasi lebih mudah ditemukan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.4s">
                    <div class="iocn-holder">
                        <span class="flaticon-medical-1"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Kegunaan Obat</h3>
                        <p>
                            Menjelaskan secara singkat kegunaan atau fungsi
                            umum dari obat berdasarkan data yang tersedia.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.5s">
                    <div class="iocn-holder">
                        <span class="flaticon-technology"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Harga Obat</h3>
                        <p>
                            Menampilkan informasi harga berdasarkan
                            data obat yang tersimpan di dalam SIFIT.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.6s">
                    <div class="iocn-holder">
                        <span class="flaticon-plus-symbol"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Stok Obat</h3>
                        <p>
                            Memberikan informasi jumlah stok obat
                            yang tercatat pada sistem.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.7s">
                    <div class="iocn-holder">
                        <span class="flaticon-ribbon"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Satuan Obat</h3>
                        <p>
                            Menampilkan satuan obat seperti tablet,
                            strip, botol, atau satuan lainnya.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.8s">
                    <div class="iocn-holder">
                        <span class="flaticon-ribbon"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Ketentuan Resep</h3>
                        <p>
                            Memberikan keterangan apakah obat
                            memerlukan resep dokter atau tidak.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CARA MENCARI --}}
<section class="service-area sifit-guide-area">
    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wow fadeInLeft" data-wow-delay="0.3s">
                    <div class="sec-title">
                        <h2>Cara Mencari Informasi Obat</h2>
                        <span class="border"></span>
                    </div>

                    <div class="text">
                        <p>
                            Pengguna dapat mencari obat melalui halaman Data Obat
                            dengan memasukkan nama obat atau memilih kategori
                            yang tersedia.
                        </p>

                        <ul class="sifit-guide-list">
                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Buka halaman Data Obat.
                            </li>

                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Masukkan nama obat pada kolom pencarian.
                            </li>

                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Gunakan kategori untuk mempersempit pencarian.
                            </li>

                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Klik Lihat Detail untuk melihat informasi obat.
                            </li>

                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Lihat bagian kegunaan untuk mengetahui fungsi umum obat.
                            </li>
                        </ul>

                        <div style="margin-top: 25px;">
                            <a href="{{ route('frontend.obat') }}" class="thm-btn bgclr-1">
                                Lihat Data Obat
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="sifit-warning-box wow fadeInRight" data-wow-delay="0.3s">
                    <div class="sec-title">
                        <h2>Perhatian</h2>
                        <span class="border"></span>
                    </div>

                    <div class="text">
                        <p>
                            Informasi obat dan kegunaan yang tersedia pada SIFIT
                            bersifat informatif dan bukan sebagai pengganti
                            konsultasi dengan dokter, apoteker, atau tenaga kesehatan.
                        </p>

                        <p>
                            Penggunaan obat harus tetap mengikuti petunjuk pada
                            kemasan, resep dokter, serta arahan tenaga kesehatan
                            yang berwenang.
                        </p>

                        <p>
                            Jangan menggunakan obat hanya berdasarkan informasi
                            yang tersedia pada website apabila obat tersebut
                            memerlukan pemeriksaan atau resep dari tenaga kesehatan.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection