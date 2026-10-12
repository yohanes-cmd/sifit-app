@extends('frontend.layouts.app')
@section('title', 'Profil, Visi & Misi - SIFIT Provinsi Riau')

@section('content')
{{-- ==========================================================================
     BREADCRUMB COMPACT RESMI
     ========================================================================== --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-info-circle" style="color: var(--sifit-accent);"></i> Profil, Visi & Misi SIFIT</h1>
                <p>Mengenal Sistem Informasi Farmasi Terintegrasi Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Profil & Visi Misi</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     1. PROFIL & IDENTITAS RESMI SIFIT
     ========================================================================== --}}
<section style="padding: 35px 0 40px; background: #ffffff;">
    <div class="container">
        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">

            {{-- KARTU KREDENSIAL RESMI INSTANSI --}}
            <div class="col-lg-5 col-md-5 col-sm-12 wow fadeInLeft" data-wow-delay="0.1s" style="margin-bottom: 20px;">
                <div class="sifit-official-badge-card" style="margin: 0; width: 100%;">
                    <div class="card-crest">
                        <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" class="emblem-sifit" style="height: 64px;">
                    </div>
                    <div class="card-body-text">
                        <span class="badge-label"><i class="fa fa-shield"></i> Portal Resmi Pelayanan Publik</span>
                        <h3>SIFIT Provinsi Riau</h3>
                        <p class="instansi">Dinas Kesehatan Pemerintah Provinsi Riau</p>
                        <div class="card-features">
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Informasi Obat Terstandarisasi</span>
                            </div>
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Publikasi & Edukasi Kefarmasian Resmi</span>
                            </div>
                            <div class="feat-item">
                                <i class="fa fa-check-circle"></i>
                                <span>Transparansi Ketersediaan Farmasi Daerah</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer-info">
                        <span class="motto">"Mewujudkan Pelayanan Kesehatan Berdaya Saing & Terpercaya"</span>
                    </div>
                </div>
            </div>

            {{-- DESKRIPSI PROFIL --}}
            <div class="col-lg-7 col-md-7 col-sm-12 wow fadeInRight" data-wow-delay="0.15s" style="margin-bottom: 20px;">
                <div style="padding-left: 10px;">
                    <span class="sifit-section-tag">Profil Instansi</span>
                    <h2 style="font-size: 24px; font-weight: 800; color: #1e293b; margin: 6px 0 12px; line-height: 1.3;">
                        Selamat Datang di Portal Resmi SIFIT
                    </h2>
                    <p style="font-size: 14px; color: #64748b; line-height: 1.65; margin-bottom: 18px;">
                        <strong>SIFIT (Sistem Informasi Farmasi Terintegrasi)</strong> adalah platform digital resmi yang dikembangkan oleh Seksi Kefarmasian & Alat Kesehatan Dinas Kesehatan Pemerintah Provinsi Riau.
                    </p>
                    <p style="font-size: 13.5px; color: #64748b; line-height: 1.65; margin-bottom: 20px;">
                        Platform ini dihadirkan untuk memberikan kemudahan bagi masyarakat, tenaga kesehatan, serta fasilitas pelayanan kesehatan dalam memperoleh informasi resmi ketersediaan obat, edukasi penggunaan obat yang aman (DAGUSIBU), serta transparansi kebijakan logistik farmasi pemerintah daerah.
                    </p>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <a href="{{ route('frontend.obat') }}" class="thm-btn" style="padding: 9px 20px; font-size: 12.5px; border-radius: 6px;">
                            <i class="fa fa-medkit"></i> Lihat Katalog Obat
                        </a>
                        <a href="{{ route('frontend.contact') }}" class="btn-style-two" style="padding: 9px 18px; font-size: 12.5px; text-decoration: none; border-radius: 6px;">
                            <i class="fa fa-phone"></i> Hubungi Pengelola
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ==========================================================================
     2. VISI & MISI TERPADU (SATU KESATUAN)
     ========================================================================== --}}
<section style="padding: 40px 0 45px; background: #f8fafc; border-top: 1px solid var(--sifit-border); border-bottom: 1px solid var(--sifit-border);">
    <div class="container">
        <div class="sifit-section-header wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 24px;">
            <span class="sifit-section-tag">Komitmen Pelayanan</span>
            <h2 class="sifit-section-title">Visi & Misi SIFIT Riau</h2>
            <p class="sifit-section-subtitle">Arah strategis dan komitmen pelayanan kefarmasian Dinas Kesehatan Pemerintah Provinsi Riau.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            {{-- VISI --}}
            <div class="col-lg-5 col-md-5 col-sm-12 wow fadeInLeft" data-wow-delay="0.15s" style="display: flex; margin-bottom: 20px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 24px; width: 100%; display: flex; flex-direction: column; justify-content: center; box-shadow: 0 4px 14px rgba(17,85,102,0.04);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <span style="width: 36px; height: 36px; border-radius: 8px; background: #f0fdfa; color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; border: 1px solid rgba(77,182,172,0.4);">
                            <i class="fa fa-eye"></i>
                        </span>
                        <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--sifit-primary);">Visi SIFIT</h3>
                    </div>
                    <div style="background: #f8fafc; border-left: 4px solid var(--sifit-accent); padding: 16px; border-radius: 0 8px 8px 0;">
                        <p style="margin: 0; font-size: 14px; line-height: 1.7; color: #334155; font-weight: 600;">
                            "Menjadi sistem informasi farmasi yang terintegrasi, mudah diakses, dan mampu mendukung penyampaian informasi obat serta informasi kefarmasian kepada masyarakat secara akurat, transparan, dan terpercaya di Provinsi Riau."
                        </p>
                    </div>
                </div>
            </div>

            {{-- MISI --}}
            <div class="col-lg-7 col-md-7 col-sm-12 wow fadeInRight" data-wow-delay="0.2s" style="display: flex; margin-bottom: 20px;">
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 24px; width: 100%; box-shadow: 0 4px 14px rgba(17,85,102,0.04);">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 14px;">
                        <span style="width: 36px; height: 36px; border-radius: 8px; background: #f0fdfa; color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; border: 1px solid rgba(77,182,172,0.4);">
                            <i class="fa fa-bullseye"></i>
                        </span>
                        <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--sifit-primary);">Misi Pelayanan</h3>
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px;">
                        <li style="display: flex; align-items: flex-start; gap: 10px; background: #f8fafc; padding: 9px 12px; border-radius: 6px; border: 1px solid #eef2f6;">
                            <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 15px; margin-top: 2px;"></i>
                            <span style="font-size: 13px; color: #334155; line-height: 1.45;">Menyediakan informasi obat yang tersusun jelas, terverifikasi, dan mudah diakses publik.</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 10px; background: #f8fafc; padding: 9px 12px; border-radius: 6px; border: 1px solid #eef2f6;">
                            <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 15px; margin-top: 2px;"></i>
                            <span style="font-size: 13px; color: #334155; line-height: 1.45;">Mempermudah pencarian ketersediaan, indikasi, dan petunjuk pemakaian obat secara digital.</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 10px; background: #f8fafc; padding: 9px 12px; border-radius: 6px; border: 1px solid #eef2f6;">
                            <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 15px; margin-top: 2px;"></i>
                            <span style="font-size: 13px; color: #334155; line-height: 1.45;">Menyajikan warta resmi, regulasi terkini, dan edukasi kefarmasian yang kredibel.</span>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 10px; background: #f8fafc; padding: 9px 12px; border-radius: 6px; border: 1px solid #eef2f6;">
                            <i class="fa fa-check-circle" style="color: var(--sifit-accent); font-size: 15px; margin-top: 2px;"></i>
                            <span style="font-size: 13px; color: #334155; line-height: 1.45;">Mendukung tata kelola logistik farmasi pemerintah daerah yang transparan dan akuntabel.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     3. TUJUAN & KEUNGGULAN SISTEM
     ========================================================================== --}}
<section style="padding: 40px 0 45px; background: #ffffff;">
    <div class="container">
        <div class="sifit-section-header wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 24px;">
            <span class="sifit-section-tag">Sasaran Strategis</span>
            <h2 class="sifit-section-title">Tujuan & Nilai Layanan</h2>
            <p class="sifit-section-subtitle">Prinsip utama yang menjadi pedoman dalam penyelenggaraan sistem informasi farmasi daerah.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.1s" style="display: flex; margin-bottom: 20px;">
                <div class="sifit-service-card" style="text-align: left; align-items: flex-start; padding: 20px;">
                    <div class="sifit-service-icon-box" style="margin-bottom: 12px; width: 44px; height: 44px; font-size: 18px;">
                        <i class="fa fa-medkit"></i>
                    </div>
                    <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 6px;">Katalog Obat Terverifikasi</h3>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.5; margin: 0;">Data obat lengkap meliputi kategori, stok, ketentuan resep, dan satuan resmi.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.2s" style="display: flex; margin-bottom: 20px;">
                <div class="sifit-service-card" style="text-align: left; align-items: flex-start; padding: 20px;">
                    <div class="sifit-service-icon-box" style="margin-bottom: 12px; width: 44px; height: 44px; font-size: 18px;">
                        <i class="fa fa-book"></i>
                    </div>
                    <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 6px;">Edukasi DAGUSIBU</h3>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.5; margin: 0;">Sosialisasi resmi mengenai tata cara Dapatkan, Gunakan, Simpan, dan Buang obat secara tepat.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.3s" style="display: flex; margin-bottom: 20px;">
                <div class="sifit-service-card" style="text-align: left; align-items: flex-start; padding: 20px;">
                    <div class="sifit-service-icon-box" style="margin-bottom: 12px; width: 44px; height: 44px; font-size: 18px;">
                        <i class="fa fa-shield"></i>
                    </div>
                    <h3 style="font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 6px;">Transparansi & Akuntabilitas</h3>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.5; margin: 0;">Mendukung keterbukaan informasi publik kefarmasian Dinas Kesehatan Provinsi Riau.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     4. HELPDESK & CALL TO ACTION BANNER
     ========================================================================== --}}
<section class="sifit-helpdesk-banner">
    <div class="container">
        <div class="sifit-helpdesk-content wow fadeInUp" data-wow-delay="0.1s">
            <div class="sifit-helpdesk-info">
                <h2>Pertanyaan Seputar Layanan Kefarmasian?</h2>
                <p>
                    Dinas Kesehatan Provinsi Riau siap membantu melayani kebutuhan informasi obat dan permohonan informasi publik Anda.
                </p>
            </div>

            <div class="sifit-helpdesk-actions">
                <a href="{{ route('frontend.contact') }}" class="sifit-btn-helpdesk-primary">
                    <i class="fa fa-phone"></i> Hubungi Tim SIFIT
                </a>
                <a href="{{ route('frontend.about.faq') }}" class="sifit-btn-helpdesk-outline">
                    <i class="fa fa-question-circle"></i> Buka Tanya Jawab (FAQ)
                </a>
            </div>
        </div>
    </div>
</section>
@endsection