@extends('frontend.layouts.app')
@section('title', 'Fitur SIFIT - SIFIT')

@section('content')

<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-th-large" style="color: var(--sifit-accent);"></i> Fitur Layanan SIFIT</h1>
                <p>Eksplorasi modul dan kemudahan pengelolaan data farmasi Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.about') }}">Tentang Kami</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Fitur SIFIT</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="medical-departments-area" style="padding: 45px 0 35px; background: #ffffff;">
    <div class="container">

        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s" style="margin-bottom: 30px;">
            <h1>Fitur Utama SIFIT</h1>
            <span class="border"></span>
            <p style="margin-top: 8px;">
                SIFIT menyediakan berbagai fitur untuk membantu masyarakat memperoleh informasi farmasi dengan lebih mudah dan terintegrasi.
            </p>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.2s" style="width: 100%; min-height: 300px; padding: 28px 22px; margin: 0; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; flex-direction: column; background: #ffffff;">
                    <div class="iocn-holder" style="height: 110px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; background: rgba(17, 85, 102, 0.05); border-radius: 8px;">
                        <span class="fa fa-medkit" style="font-size: 60px; line-height: 1; color: #115566;"></span>
                    </div>
                    <div class="text-holder" style="padding: 0;">
                        <h3 style="margin-bottom: 10px; color: #115566;">Data Obat</h3>
                        <p style="margin: 0; line-height: 24px; color: #64748b;">
                            Menampilkan informasi obat yang tersedia di dalam sistem secara terstruktur dan mudah dipahami.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.3s" style="width: 100%; min-height: 300px; padding: 28px 22px; margin: 0; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; flex-direction: column; background: #ffffff;">
                    <div class="iocn-holder" style="height: 110px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; background: rgba(17, 85, 102, 0.05); border-radius: 8px;">
                        <span class="fa fa-folder-open" style="font-size: 60px; line-height: 1; color: #115566;"></span>
                    </div>
                    <div class="text-holder" style="padding: 0;">
                        <h3 style="margin-bottom: 10px; color: #115566;">Kategori Obat</h3>
                        <p style="margin: 0; line-height: 24px; color: #64748b;">
                            Mengelompokkan data obat berdasarkan kategori sehingga pengguna lebih mudah menemukan informasi yang dibutuhkan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.4s" style="width: 100%; min-height: 300px; padding: 28px 22px; margin: 0; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; flex-direction: column; background: #ffffff;">
                    <div class="iocn-holder" style="height: 110px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; background: rgba(17, 85, 102, 0.05); border-radius: 8px;">
                        <span class="fa fa-search" style="font-size: 60px; line-height: 1; color: #115566;"></span>
                    </div>
                    <div class="text-holder" style="padding: 0;">
                        <h3 style="margin-bottom: 10px; color: #115566;">Pencarian Obat</h3>
                        <p style="margin: 0; line-height: 24px; color: #64748b;">
                            Mempermudah pengguna mencari data obat berdasarkan nama melalui fitur pencarian yang tersedia.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.5s" style="width: 100%; min-height: 300px; padding: 28px 22px; margin: 0; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; flex-direction: column; background: #ffffff;">
                    <div class="iocn-holder" style="height: 110px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; background: rgba(17, 85, 102, 0.05); border-radius: 8px;">
                        <span class="fa fa-cubes" style="font-size: 60px; line-height: 1; color: #115566;"></span>
                    </div>
                    <div class="text-holder" style="padding: 0;">
                        <h3 style="margin-bottom: 10px; color: #115566;">Informasi Stok</h3>
                        <p style="margin: 0; line-height: 24px; color: #64748b;">
                            Memberikan informasi mengenai ketersediaan stok obat yang tercatat di dalam sistem SIFIT.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.6s" style="width: 100%; min-height: 300px; padding: 28px 22px; margin: 0; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; flex-direction: column; background: #ffffff;">
                    <div class="iocn-holder" style="height: 110px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; background: rgba(17, 85, 102, 0.05); border-radius: 8px;">
                        <span class="fa fa-newspaper-o" style="font-size: 60px; line-height: 1; color: #115566;"></span>
                    </div>
                    <div class="text-holder" style="padding: 0;">
                        <h3 style="margin-bottom: 10px; color: #115566;">Berita Farmasi</h3>
                        <p style="margin: 0; line-height: 24px; color: #64748b;">
                            Menyediakan berita dan informasi terbaru yang berkaitan dengan bidang farmasi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                <div class="single-item text-center wow fadeInUp" data-wow-delay="0.7s" style="width: 100%; min-height: 300px; padding: 28px 22px; margin: 0; border: 1px solid #e2e8f0; border-radius: 8px; display: flex; flex-direction: column; background: #ffffff;">
                    <div class="iocn-holder" style="height: 110px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; background: rgba(17, 85, 102, 0.05); border-radius: 8px;">
                        <span class="fa fa-shopping-basket" style="font-size: 60px; line-height: 1; color: #115566;"></span>
                    </div>
                    <div class="text-holder" style="padding: 0;">
                        <h3 style="margin-bottom: 10px; color: #115566;">Keranjang Permintaan</h3>
                        <p style="margin: 0; line-height: 24px; color: #64748b;">
                            Fitur pengumpulan obat ke dalam keranjang untuk mempermudah permohonan atau pemeriksaan data obat.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<section class="service-area" style="padding: 50px 0 60px; background: #f8fafc;">
    <div class="container">

        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s" style="margin-bottom: 30px;">
            <h1>Kemudahan Menggunakan SIFIT</h1>
            <span class="border"></span>
            <p style="margin-top: 8px;">
                Fitur-fitur SIFIT dirancang untuk membantu pengguna menemukan informasi farmasi secara lebih cepat dan terarah.
            </p>
        </div>

        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                <div class="sifit-official-badge-card wow fadeInLeft" data-wow-delay="0.3s">
                    <div class="card-crest">
                        <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" class="emblem-sifit" style="height: 60px;">
                    </div>
                    <div class="card-body-text">
                        <span class="badge-label"><i class="fa fa-cubes"></i> Ekosistem Layanan Farmasi</span>
                        <h3>Integrasi Satu Pintu SIFIT</h3>
                        <p class="instansi">Dinas Kesehatan Provinsi Riau</p>
                        <div class="card-features">
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Pencarian Cepat & Direktori Obat Lengkap</span>
                            </div>
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Sistem Keranjang & Pengajuan Kebutuhan Obat</span>
                            </div>
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Publikasi Regulasi, Berita, & Media Edukasi</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer-info">
                        <span class="motto">"Mendukung Pelayanan Farmasi Publik Modern & Transparan"</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin-bottom: 25px;">
                <div class="text-holder wow fadeInRight" data-wow-delay="0.3s">

                    <div class="title" style="margin-bottom: 16px;">
                        <h2 style="font-size: 24px; font-weight: 800; color: #115566; margin: 0 0 10px;">Informasi dalam Satu Sistem</h2>
                    </div>

                    <div class="text" style="color: #475569; line-height: 1.7; margin-bottom: 20px;">
                        <p style="margin-bottom: 12px;">
                            SIFIT menggabungkan data obat dan informasi farmasi dalam satu sistem sehingga pengguna tidak perlu mencari informasi melalui banyak halaman yang berbeda.
                        </p>

                        <p>
                            Pengguna dapat mencari data obat, melihat kategori, mengetahui informasi stok, serta membaca berita farmasi melalui layanan yang tersedia.
                        </p>
                    </div>

                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-weight: 600; color: #1e293b;">
                            <i class="fa fa-check-circle" style="color: #4db6ac; font-size: 16px;"></i>
                            Informasi obat lebih terstruktur dan akurat.
                        </li>

                        <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-weight: 600; color: #1e293b;">
                            <i class="fa fa-check-circle" style="color: #4db6ac; font-size: 16px;"></i>
                            Pencarian data lebih cepat dan efisien.
                        </li>

                        <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-weight: 600; color: #1e293b;">
                            <i class="fa fa-check-circle" style="color: #4db6ac; font-size: 16px;"></i>
                            Informasi farmasi terpadu dalam satu portal resmi.
                        </li>

                        <li style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px; font-weight: 600; color: #1e293b;">
                            <i class="fa fa-check-circle" style="color: #4db6ac; font-size: 16px;"></i>
                            Tampilan formal, ramah pengguna, dan responsif di semua perangkat.
                        </li>
                    </ul>

                </div>
            </div>

        </div>

    </div>
</section>

@endsection