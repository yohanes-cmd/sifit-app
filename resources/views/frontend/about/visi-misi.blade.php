@extends('frontend.layouts.app')
@section('title', 'Visi & Misi - SIFIT Provinsi Riau')

@section('content')
{{-- ==========================================================================
     BREADCRUMB COMPACT RESMI
     ========================================================================== --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-bullseye" style="color: var(--sifit-accent);"></i> Visi, Misi & Tujuan SIFIT</h1>
                <p>Arah strategis dan komitmen pelayanan kefarmasian Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.about') }}">Tentang Kami</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Visi & Misi</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     VISI & MISI RESMI
     ========================================================================== --}}
<section class="welcome-area" style="padding: 40px 0 35px; background: #ffffff;">
    <div class="container">
        <div class="sec-title text-center wow fadeInUp" data-wow-delay="0.2s" style="margin-bottom: 30px;">
            <span class="sifit-pill-badge"><i class="fa fa-star"></i> Komitmen Pelayanan</span>
            <h2 style="font-size: 26px; font-weight: 800; color: var(--sifit-primary); margin-top: 8px;">Visi & Misi SIFIT</h2>
            <span class="border"></span>
            <p style="color: #64748b; font-size: 14px; max-width: 600px; margin: 0 auto;">Landasan utama pengelolaan dan keterbukaan informasi kefarmasian untuk masyarakat Provinsi Riau.</p>
        </div>

        <div class="row" style="display: flex; align-items: stretch; flex-wrap: wrap;">
            {{-- KREDENSIAL PEMERINTAH --}}
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                <div class="sifit-official-badge-card wow fadeInLeft" data-wow-delay="0.2s" style="height: 100%; margin: 0;">
                    <div class="card-crest">
                        <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" class="emblem-sifit" style="height: 60px;">
                    </div>
                    <div class="card-body-text">
                        <span class="badge-label"><i class="fa fa-shield"></i> Portal Resmi Pemerintah</span>
                        <h3>SIFIT Provinsi Riau</h3>
                        <p class="instansi">Dinas Kesehatan Provinsi Riau</p>
                        <div class="card-features">
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Standarisasi Data Obat & Kefarmasian</span>
                            </div>
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Transparansi Informasi Publik</span>
                            </div>
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Pelayanan Kesehatan Terintegrasi</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer-info">
                        <span class="motto">"Mewujudkan Pelayanan Farmasi Riau yang Cepat, Akurat, dan Terpercaya"</span>
                    </div>
                </div>
            </div>

            {{-- VISI & MISI DETAIL --}}
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
                <div class="sifit-vision-mission-box wow fadeInRight" data-wow-delay="0.2s" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 26px 28px; height: 100%;">
                    {{-- VISI --}}
                    <div style="margin-bottom: 22px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <span style="width: 32px; height: 32px; border-radius: 8px; background: rgba(17, 85, 102, 0.1); color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 800;">1</span>
                            <h3 style="margin: 0; font-size: 19px; font-weight: 800; color: var(--sifit-primary);">Visi</h3>
                        </div>
                        <div style="background: #ffffff; border-left: 4px solid var(--sifit-accent); padding: 14px 18px; border-radius: 0 8px 8px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #334155; font-weight: 500;">
                                Menjadi sistem informasi farmasi yang terintegrasi, mudah diakses, dan mampu mendukung penyampaian informasi obat serta informasi kefarmasian kepada masyarakat secara akurat dan transparan.
                            </p>
                        </div>
                    </div>

                    {{-- MISI --}}
                    <div>
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <span style="width: 32px; height: 32px; border-radius: 8px; background: rgba(17, 85, 102, 0.1); color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 800;">2</span>
                            <h3 style="margin: 0; font-size: 19px; font-weight: 800; color: var(--sifit-primary);">Misi</h3>
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                            <li style="display: flex; align-items: flex-start; gap: 12px; background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #eef2f6;">
                                <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 16px; margin-top: 2px;"></i>
                                <span style="font-size: 13.5px; color: #334155; line-height: 1.5;">Menyediakan informasi obat yang tersusun secara jelas, terverifikasi, dan mudah diakses oleh seluruh lapisan masyarakat.</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 12px; background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #eef2f6;">
                                <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 16px; margin-top: 2px;"></i>
                                <span style="font-size: 13.5px; color: #334155; line-height: 1.5;">Mempermudah masyarakat dalam mencari informasi ketersediaan, dosis, dan petunjuk obat melalui sistem digital terintegrasi.</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 12px; background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #eef2f6;">
                                <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 16px; margin-top: 2px;"></i>
                                <span style="font-size: 13.5px; color: #334155; line-height: 1.5;">Menyajikan berita resmi, regulasi terkini, dan edukasi kefarmasian yang kredibel dari Dinas Kesehatan.</span>
                            </li>
                            <li style="display: flex; align-items: flex-start; gap: 12px; background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #eef2f6;">
                                <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 16px; margin-top: 2px;"></i>
                                <span style="font-size: 13.5px; color: #334155; line-height: 1.5;">Mendukung tata kelola dan efisiensi manajemen data logistik farmasi pemerintah daerah yang akuntabel.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     TUJUAN SIFIT
     ========================================================================== --}}
<section class="medical-departments-area" style="padding: 35px 0 45px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
    <div class="container">
        <div class="sec-title text-center wow fadeInUp" data-wow-delay="0.2s" style="margin-bottom: 28px;">
            <span class="sifit-pill-badge"><i class="fa fa-flag"></i> Sasaran Program</span>
            <h2 style="font-size: 24px; font-weight: 800; color: var(--sifit-primary); margin-top: 8px;">Tujuan Strategis SIFIT</h2>
            <span class="border"></span>
            <p style="color: #64748b; font-size: 13.5px; max-width: 650px; margin: 0 auto;">SIFIT dikembangkan sebagai sarana penunjang keterbukaan informasi obat dan peningkatan literasi kesehatan masyarakat.</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item wow fadeInUp" data-wow-delay="0.2s">
                    <div class="iocn-holder">
                        <i class="fa fa-medkit" style="font-size: 32px; color: var(--sifit-primary);"></i>
                    </div>
                    <div class="text-holder">
                        <h3>Informasi Obat Lengkap</h3>
                        <p>Mempermudah pengguna memperoleh katalog data obat, komposisi, indikasi, dan petunjuk pemakaian resmi.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item wow fadeInUp" data-wow-delay="0.3s">
                    <div class="iocn-holder">
                        <i class="fa fa-mobile-phone" style="font-size: 36px; color: var(--sifit-primary);"></i>
                    </div>
                    <div class="text-holder">
                        <h3>Akses Digital Mudah</h3>
                        <p>Menyediakan platform layanan publik yang responsif, cepat, dan ramah pengguna di berbagai perangkat.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="single-item wow fadeInUp" data-wow-delay="0.4s">
                    <div class="iocn-holder">
                        <i class="fa fa-cubes" style="font-size: 30px; color: var(--sifit-primary);"></i>
                    </div>
                    <div class="text-holder">
                        <h3>Informasi Terintegrasi</h3>
                        <p>Menyatukan basis data farmasi, edukasi kesehatan DAGUSIBU, dan berita resmi dalam satu gerbang.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection