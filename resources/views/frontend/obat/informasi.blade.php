@extends('frontend.layouts.app')
@section('title', 'Informasi Obat - SIFIT')

@section('content')
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

<section class="welcome-area" style="padding: 80px 0;">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Informasi Obat di SIFIT</h1>
            <span class="border"></span>
            <p>SIFIT menyediakan informasi obat untuk membantu masyarakat memperoleh data yang lebih mudah dibaca dan terstruktur.</p>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="img-holder wow fadeInLeft" data-wow-delay="0.3s" style="margin-bottom: 30px;">
                    <img
                        src="{{ asset('frontend/images/resources/welcome.jpg') }}"
                        alt="Informasi Obat SIFIT"
                        class="img-responsive"
                    >
                </div>
            </div>

            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="text-holder wow fadeInRight" data-wow-delay="0.3s">
                    <div class="title" style="margin-bottom: 20px;">
                        <h2>Tentang Informasi Obat</h2>
                    </div>

                    <div class="text">
                        <p style="line-height: 28px; margin-bottom: 18px;">
                            Informasi obat pada SIFIT menampilkan data obat yang telah tersedia di dalam sistem, seperti nama obat, kategori, harga, stok, satuan, dan ketentuan resep dokter.
                        </p>

                        <p style="line-height: 28px;">
                            Informasi tersebut membantu pengguna mengenali data dasar obat sebelum melihat detail obat yang tersedia pada halaman Data Obat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="medical-departments-area" style="padding: 70px 0;">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Informasi yang Tersedia</h1>
            <span class="border"></span>
            <p>Beberapa informasi utama yang dapat dilihat melalui data obat pada SIFIT.</p>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.2s" style="margin-bottom: 30px;">
                    <div class="iocn-holder">
                        <span class="flaticon-medical"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Nama Obat</h3>
                        <p>Menampilkan nama obat yang telah tercatat dan dipublikasikan di dalam sistem.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.3s" style="margin-bottom: 30px;">
                    <div class="iocn-holder">
                        <span class="flaticon-agenda"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Kategori Obat</h3>
                        <p>Mengelompokkan obat berdasarkan kategori agar informasi lebih mudah ditemukan.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.4s" style="margin-bottom: 30px;">
                    <div class="iocn-holder">
                        <span class="flaticon-technology"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Harga Obat</h3>
                        <p>Menampilkan informasi harga berdasarkan data obat yang tersimpan di dalam SIFIT.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.5s" style="margin-bottom: 30px;">
                    <div class="iocn-holder">
                        <span class="flaticon-plus-symbol"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Stok Obat</h3>
                        <p>Memberikan informasi jumlah stok obat yang tercatat pada sistem.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.6s" style="margin-bottom: 30px;">
                    <div class="iocn-holder">
                        <span class="flaticon-ribbon"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Satuan Obat</h3>
                        <p>Menampilkan satuan yang digunakan pada data obat apabila informasi tersebut tersedia.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.7s" style="margin-bottom: 30px;">
                    <div class="iocn-holder">
                        <span class="flaticon-medical-1"></span>
                    </div>
                    <div class="text-holder">
                        <h3>Ketentuan Resep</h3>
                        <p>Memberikan keterangan apakah obat memerlukan resep dokter atau tidak.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service-area" style="padding: 75px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wow fadeInLeft" data-wow-delay="0.3s">
                    <div class="sec-title">
                        <h2>Cara Mencari Informasi Obat</h2>
                        <span class="border"></span>
                    </div>

                    <div class="text">
                        <p style="line-height: 28px; margin-bottom: 20px;">
                            Pengguna dapat mencari obat melalui halaman Data Obat dengan memasukkan nama obat pada kolom pencarian atau memilih kategori yang tersedia.
                        </p>

                        <ul>
                            <li style="margin-bottom: 15px;">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Buka halaman Data Obat.
                            </li>
                            <li style="margin-bottom: 15px;">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Masukkan nama obat pada kolom pencarian.
                            </li>
                            <li style="margin-bottom: 15px;">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Gunakan kategori untuk mempersempit data.
                            </li>
                            <li>
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Pilih Lihat Detail untuk melihat informasi obat.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="wow fadeInRight" data-wow-delay="0.3s">
                    <div class="sec-title">
                        <h2>Perhatian</h2>
                        <span class="border"></span>
                    </div>

                    <div class="text">
                        <p style="line-height: 28px; margin-bottom: 18px;">
                            Informasi yang tersedia di SIFIT digunakan sebagai informasi data obat dan bukan sebagai pengganti konsultasi dengan dokter, apoteker, atau tenaga kesehatan.
                        </p>

                        <p style="line-height: 28px;">
                            Penggunaan obat harus tetap mengikuti petunjuk pada kemasan, resep, serta arahan tenaga kesehatan yang berwenang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection