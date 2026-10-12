@extends('frontend.layouts.app')
@section('title', 'Informasi Obat & Pedoman DAGUSIBU - SIFIT')

@section('content')
<style>
    .sifit-info-section {
        padding: 24px 0 45px;
        background: #f8fafc;
    }
    .sifit-info-intro-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 22px 24px;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.04);
        margin-bottom: 20px;
    }
    .sifit-feature-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 14px 16px;
        height: 100%;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        box-shadow: 0 2px 10px rgba(17, 85, 102, 0.03);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .sifit-feature-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(17, 85, 102, 0.08);
        border-color: var(--sifit-accent);
    }
    .sifit-feature-icon {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #f0fdfa;
        border: 1px solid rgba(77, 182, 172, 0.4);
        color: var(--sifit-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .sifit-feature-card:hover .sifit-feature-icon {
        background: var(--sifit-primary);
        color: #ffffff;
        border-color: var(--sifit-primary);
    }
    .sifit-guide-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 22px 24px;
        height: 100%;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.04);
    }
    .sifit-step-list {
        list-style: none;
        padding: 0;
        margin: 0 0 18px 0;
    }
    .sifit-step-list li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 13px;
        color: #334155;
        line-height: 1.5;
    }
    .sifit-step-list li i {
        color: var(--sifit-accent);
        font-size: 14px;
        margin-top: 3px;
        flex-shrink: 0;
    }
    .sifit-notice-box {
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-left: 4px solid #f59e0b;
        border-radius: 6px;
        padding: 14px 16px;
        font-size: 12.5px;
        color: #92400e;
        line-height: 1.55;
    }
    @media (max-width: 767px) {
        .sifit-info-intro-card,
        .sifit-guide-card {
            padding: 16px 14px;
        }
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-info-circle" style="color: var(--sifit-accent);"></i> Panduan Informasi Obat & DAGUSIBU</h1>
                <p>Pedoman resmi penggunaan, ketersediaan, dan regulasi kefarmasian Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.obat') }}">Data Obat</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Informasi Obat</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KONTEN UTAMA --}}
<section class="sifit-info-section">
    <div class="container">

        {{-- BAGIAN 1: PENGANTAR RESMI (Compact Unified Card) --}}
        <div class="sifit-info-intro-card wow fadeInUp" data-wow-delay="0.05s">
            <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                
                {{-- Kolom Kiri: Kredensial --}}
                <div class="col-lg-5 col-md-5 col-sm-12" style="margin-bottom: 12px;">
                    <div class="sifit-official-badge-card" style="margin: 0; width: 100%;">
                        <div class="card-crest">
                            <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" class="emblem-sifit" style="height: 60px;">
                        </div>
                        <div class="card-body-text">
                            <span class="badge-label"><i class="fa fa-heartbeat"></i> Edukasi Kefarmasian Resmi</span>
                            <h3 style="font-size: 16px; margin: 0 0 2px;">Pedoman Obat SIFIT</h3>
                            <p class="instansi" style="margin-bottom: 8px;">Dinas Kesehatan Pemerintah Provinsi Riau</p>
                            <div class="card-features">
                                <div class="feat-item">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Informasi Indikasi & Kategori Obat</span>
                                </div>
                                <div class="feat-item">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Ketentuan Resep Dokter & Obat Bebas</span>
                                </div>
                                <div class="feat-item">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Prinsip Keamanan DAGUSIBU Kemenkes</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer-info" style="padding: 8px 14px;">
                            <span class="motto" style="font-size: 11.5px;">"Gunakan Obat Secara Tepat, Aman, dan Rasional"</span>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Narasi Ringkas --}}
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div style="padding-left: 10px;">
                        <span class="sifit-section-tag" style="margin-bottom: 6px;">Transparansi Data</span>
                        <h2 style="font-size: 20px; font-weight: 800; color: #1e293b; margin: 0 0 10px; line-height: 1.35;">
                            Direktori & Standarisasi Data Obat SIFIT Riau
                        </h2>
                        <p style="font-size: 13.5px; color: #64748b; line-height: 1.6; margin-bottom: 12px;">
                            SIFIT menyajikan data obat yang dikelola langsung oleh instalasi farmasi Dinas Kesehatan Provinsi Riau. Melalui sistem ini, masyarakat dan fasilitas kesehatan dapat mengetahui informasi nama obat, indikasi terapi, harga resmi, stok ketersediaan, serta ketentuan resep dokter secara transparan.
                        </p>
                        <p style="font-size: 13px; color: #64748b; line-height: 1.6; margin-bottom: 16px;">
                            Setiap data obat yang terdaftar telah melalui proses verifikasi kefarmasian guna menjamin keaslian, kepatuhan regulasi, serta keselamatan penggunaan oleh pasien.
                        </p>

                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ route('frontend.obat') }}" class="thm-btn" style="padding: 8px 18px; font-size: 12.5px; border-radius: 4px;">
                                <i class="fa fa-medkit"></i> Buka Katalog Obat
                            </a>
                            <a href="{{ route('frontend.contact') }}" class="btn-style-two" style="padding: 8px 16px; font-size: 12.5px; text-decoration: none; border-radius: 4px;">
                                <i class="fa fa-phone"></i> Konsultasi Farmasi
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- BAGIAN 2: 6 INFORMASI YANG TERSEDIA (Compact 3x2 Grid) --}}
        <div style="margin-bottom: 20px;">
            <div style="margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; color: var(--sifit-primary); margin: 0;">
                        Komponen Informasi Obat Terdaftar
                    </h3>
                    <span style="font-size: 12px; color: #64748b;">Parameter data utama yang dapat diakses pengguna pada setiap rincian obat</span>
                </div>
            </div>

            <div class="row" style="display: flex; flex-wrap: wrap;">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.05s" style="display: flex; margin-bottom: 12px;">
                    <div class="sifit-feature-card" style="width: 100%;">
                        <div class="sifit-feature-icon">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <div>
                            <strong style="color: #1e293b; font-size: 13.5px; display: block; margin-bottom: 2px;">Nama Obat & Zat Aktif</strong>
                            <p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.45;">Nama dagang, bentuk generik, dan komposisi zat aktif terdaftar.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.1s" style="display: flex; margin-bottom: 12px;">
                    <div class="sifit-feature-card" style="width: 100%;">
                        <div class="sifit-feature-icon">
                            <i class="fa fa-th-list"></i>
                        </div>
                        <div>
                            <strong style="color: #1e293b; font-size: 13.5px; display: block; margin-bottom: 2px;">Kategori & Golongan</strong>
                            <p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.45;">Pengelompokan indikasi terapi seperti analgesik, antibiotik, dsb.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.15s" style="display: flex; margin-bottom: 12px;">
                    <div class="sifit-feature-card" style="width: 100%;">
                        <div class="sifit-feature-icon">
                            <i class="fa fa-tag"></i>
                        </div>
                        <div>
                            <strong style="color: #1e293b; font-size: 13.5px; display: block; margin-bottom: 2px;">Harga Terstandar</strong>
                            <p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.45;">Transparansi harga satuan resmi farmasi Dinas Kesehatan Riau.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.2s" style="display: flex; margin-bottom: 12px;">
                    <div class="sifit-feature-card" style="width: 100%;">
                        <div class="sifit-feature-icon">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <div>
                            <strong style="color: #1e293b; font-size: 13.5px; display: block; margin-bottom: 2px;">Stok Ketersediaan</strong>
                            <p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.45;">Kuantitas stok riil pada fasilitas instalasi farmasi penyedia.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.25s" style="display: flex; margin-bottom: 12px;">
                    <div class="sifit-feature-card" style="width: 100%;">
                        <div class="sifit-feature-icon">
                            <i class="fa fa-balance-scale"></i>
                        </div>
                        <div>
                            <strong style="color: #1e293b; font-size: 13.5px; display: block; margin-bottom: 2px;">Bentuk & Satuan Kemasan</strong>
                            <p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.45;">Bentuk sediaan seperti tablet, strip, botol, ampul, atau blister.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.3s" style="display: flex; margin-bottom: 12px;">
                    <div class="sifit-feature-card" style="width: 100%;">
                        <div class="sifit-feature-icon">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                        <div>
                            <strong style="color: #1e293b; font-size: 13.5px; display: block; margin-bottom: 2px;">Ketentuan Regulasi Resep</strong>
                            <p style="margin: 0; font-size: 12px; color: #64748b; line-height: 1.45;">Klasifikasi obat bebas, bebas terbatas, atau wajib resep dokter.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN 3: PANDUAN PENCARIAN & PERHATIAN (Side-by-Side Balanced Cards) --}}
        <div class="row">
            
            {{-- Panduan Cara Mencari --}}
            <div class="col-lg-6 col-md-6 col-sm-12 wow fadeInLeft" data-wow-delay="0.1s" style="margin-bottom: 16px;">
                <div class="sifit-guide-card">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--sifit-primary); margin: 0 0 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-search" style="color: var(--sifit-accent);"></i> Cara Mencari Informasi Obat
                    </h3>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.5; margin-bottom: 14px;">
                        Ikuti langkah mudah berikut untuk menemukan informasi obat yang Anda perlukan:
                    </p>

                    <ul class="sifit-step-list">
                        <li>
                            <i class="fa fa-check-circle"></i>
                            <span>Buka halaman <strong>Data Obat</strong> melalui menu navigasi utama.</span>
                        </li>
                        <li>
                            <i class="fa fa-check-circle"></i>
                            <span>Ketikkan nama obat, merk dagang, atau zat aktif pada kolom pencarian.</span>
                        </li>
                        <li>
                            <i class="fa fa-check-circle"></i>
                            <span>Gunakan filter kategori di sebelah kiri untuk mempersempit daftar.</span>
                        </li>
                        <li>
                            <i class="fa fa-check-circle"></i>
                            <span>Klik kartu obat untuk melihat keterangan lengkap dan aturan pemakaian.</span>
                        </li>
                    </ul>

                    <a href="{{ route('frontend.obat') }}" class="thm-btn" style="padding: 8px 18px; font-size: 12.5px; border-radius: 4px; text-decoration: none;">
                        <i class="fa fa-arrow-right" style="margin-right: 4px;"></i> Telusuri Katalog Obat Sekarang
                    </a>
                </div>
            </div>

            {{-- Perhatian & Ketentuan Keamanan --}}
            <div class="col-lg-6 col-md-6 col-sm-12 wow fadeInRight" data-wow-delay="0.15s" style="margin-bottom: 16px;">
                <div class="sifit-guide-card">
                    <h3 style="font-size: 16px; font-weight: 800; color: #991b1b; margin: 0 0 8px; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-exclamation-triangle" style="color: #dc2626;"></i> Perhatian & Keamanan Pasien
                    </h3>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.5; margin-bottom: 12px;">
                        Harap perhatikan ketentuan penting dalam penggunaan informasi kefarmasian:
                    </p>

                    <div class="sifit-notice-box">
                        <div style="margin-bottom: 8px;">
                            <strong>1. Bukan Pengganti Konsultasi Medis:</strong> Informasi obat pada portal ini bersifat edukatif dan tidak menggantikan anjuran dokter atau apoteker.
                        </div>
                        <div style="margin-bottom: 8px;">
                            <strong>2. Kepatuhan Resep Dokter:</strong> Obat bertanda resep dokter wajib disertai instruksi sah dari tenaga medis berwenang sebelum penyerahan.
                        </div>
                        <div>
                            <strong>3. Prinsip DAGUSIBU:</strong> Pastikan Anda selalu <em>Dapatkan, Gunakan, Simpan, dan Buang</em> obat sesuai tata cara baku Kementerian Kesehatan.
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection