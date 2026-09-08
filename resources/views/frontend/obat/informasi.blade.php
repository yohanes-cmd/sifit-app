@extends('frontend.layouts.app')
@section('title', 'Informasi Obat - SIFIT')

@section('content')
<style>
    .sifit-info-intro {
        padding: 38px 0 32px;
    }

    .sifit-info-intro .sec-title {
        margin-bottom: 20px;
    }

    .sifit-info-intro .sec-title p {
        margin-top: 8px;
        line-height: 24px;
    }

    .sifit-info-intro .img-holder {
        height: 270px;
        overflow: hidden;
        border-radius: 6px;
    }

    .sifit-info-intro .img-holder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .sifit-info-intro .text-holder {
        padding-left: 15px;
    }

    .sifit-info-intro .text-holder h2 {
        margin: 0 0 10px;
    }

    .sifit-info-intro .text-holder p {
        line-height: 24px;
        margin-bottom: 10px;
    }

    .sifit-information-area {
        padding: 35px 0 25px;
    }

    .sifit-information-area .sec-title {
        margin-bottom: 20px;
    }

    .sifit-information-area .sec-title p {
        margin-top: 8px;
        line-height: 24px;
    }

    .sifit-information-row {
        display: flex;
        flex-wrap: wrap;
    }

    .sifit-information-wrapper {
        display: flex;
        margin-bottom: 18px;
    }

    .sifit-information-card {
        width: 100%;
        min-height: 170px;
        margin-bottom: 0 !important;
        padding: 14px 12px;
        border: 1px solid #eeeeee;
        border-radius: 6px;
        background: #ffffff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .sifit-information-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.07);
    }

    .sifit-information-card .iocn-holder {
        margin-bottom: 8px;
    }

    .sifit-information-card .iocn-holder span {
        font-size: 40px;
    }

    .sifit-information-card .text-holder {
        padding: 8px 5px 0 !important;
    }

    .sifit-information-card .text-holder h3 {
        margin-bottom: 6px;
        font-size: 18px;
        line-height: 24px;
    }

    .sifit-information-card .text-holder p {
        line-height: 22px;
        margin: 0;
    }

    .sifit-guide-area {
        padding: 38px 0 45px;
    }

    .sifit-guide-area .sec-title {
        margin-bottom: 12px;
    }

    .sifit-guide-area .sec-title h2 {
        margin-bottom: 6px;
    }

    .sifit-guide-area p {
        line-height: 24px;
        margin-bottom: 10px;
    }

    .sifit-guide-list {
        margin-top: 12px;
    }

    .sifit-guide-list li {
        margin-bottom: 8px;
        line-height: 22px;
    }

    .sifit-guide-list li i {
        margin-right: 7px;
    }

    .sifit-guide-button {
        margin-top: 15px;
    }

    .sifit-guide-button .thm-btn {
        padding: 9px 14px;
        font-size: 13px;
    }

    .sifit-warning-box {
        padding-left: 18px;
    }

    .sifit-warning-box .text {
        padding: 12px 14px;
        background: #f8f8f8;
        border-left: 3px solid #0b98d1;
    }

    .sifit-warning-box .text p:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 991px) {
        .sifit-info-intro .text-holder {
            padding-left: 0;
            margin-top: 20px;
        }

        .sifit-warning-box {
            padding-left: 0;
            margin-top: 25px;
        }

        .sifit-info-intro .img-holder {
            height: 240px;
        }
    }

    @media (max-width: 767px) {
        .sifit-info-intro,
        .sifit-information-area,
        .sifit-guide-area {
            padding: 30px 0;
        }

        .sifit-information-row {
            display: block;
        }

        .sifit-information-wrapper {
            display: block;
        }

        .sifit-information-card {
            min-height: auto;
        }

        .sifit-info-intro .img-holder {
            height: 220px;
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
                    >
                </div>
            </div>

            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="text-holder wow fadeInRight" data-wow-delay="0.3s">

                    <h2>Tentang Informasi Obat</h2>

                    <p>
                        Informasi obat pada SIFIT menampilkan data obat yang
                        telah tersedia di dalam sistem seperti nama obat,
                        kategori, harga, stok, satuan, dan ketentuan resep.
                    </p>

                    <p>
                        Informasi tersebut membantu pengguna memahami data obat
                        yang tersedia secara lebih ringkas dan terstruktur.
                    </p>

                    <p>
                        Untuk melihat informasi masing-masing obat secara lengkap,
                        pengguna dapat membuka halaman Data Obat lalu memilih obat
                        yang ingin dilihat.
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

        <div class="row sifit-information-row">

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sifit-information-wrapper">
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

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sifit-information-wrapper">
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

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sifit-information-wrapper">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.4s">
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

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sifit-information-wrapper">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.5s">
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

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sifit-information-wrapper">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.6s">
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

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sifit-information-wrapper">
                <div class="single-item text-center sifit-information-card wow fadeInUp" data-wow-delay="0.7s">
                    <div class="iocn-holder">
                        <span class="flaticon-medical-1"></span>
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
                            dengan memasukkan nama obat atau memilih kategori yang tersedia.
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
                                Klik nama atau gambar obat untuk melihat detail.
                            </li>

                        </ul>

                        <div class="sifit-guide-button">
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
                            Informasi obat yang tersedia pada SIFIT bersifat informatif
                            dan bukan sebagai pengganti konsultasi dengan dokter,
                            apoteker, atau tenaga kesehatan.
                        </p>

                        <p>
                            Penggunaan obat harus tetap mengikuti petunjuk pada kemasan,
                            resep dokter, serta arahan tenaga kesehatan yang berwenang.
                        </p>

                        <p>
                            Jangan menggunakan obat hanya berdasarkan informasi pada
                            website apabila obat tersebut membutuhkan pemeriksaan
                            atau resep dari tenaga kesehatan.
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>
@endsection