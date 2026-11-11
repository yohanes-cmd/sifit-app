@extends('frontend.layouts.app')
@section('title', 'Tanya Jawab (FAQ) - SIFIT Provinsi Riau')

@section('content')
<style>
    .faq-content-area {
        padding: 30px 0 50px;
        background: #f8fafc;
    }
</style>

{{-- ==========================================================================
     BREADCRUMB COMPACT RESMI
     ========================================================================== --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-question-circle" style="color: var(--sifit-accent);"></i> Tanya Jawab (FAQ) SIFIT</h1>
                <p>Panduan pertanyaan umum dan jawaban seputar layanan informasi farmasi terpadu</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.about') }}">Tentang Kami</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">FAQ</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     KONTEN UTAMA FAQ & PUSAT BANTUAN
     ========================================================================== --}}
<section class="faq-content-area">
    <div class="container">
        
        <div class="sifit-section-header wow fadeInUp" data-wow-delay="0.1s" style="margin-bottom: 24px;">
            <span class="sifit-section-tag">Pusat Bantuan & Edukasi</span>
            <h2 class="sifit-section-title">Pertanyaan yang Sering Diajukan (FAQ)</h2>
            <p class="sifit-section-subtitle">Temukan informasi praktis seputar tata cara pencarian obat, ketersediaan stok, regulasi, dan fitur pelayanan SIFIT Riau.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row">
            {{-- KOLOM KIRI: ACCORDION FAQ MODERN (DINAMIS DATABASE) --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="accordion-box">
                    
                    @forelse($faqs as $index => $item)
                        <div class="accordion accordion-block wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.05) }}s">
                            <div class="accord-btn {{ $index === 0 ? 'active' : '' }}">
                                <h4>
                                    <i class="fa fa-question-circle"></i>
                                    <span>{{ $item->question }}</span>
                                </h4>
                                <span class="sifit-faq-indicator"><i class="fa fa-chevron-down"></i></span>
                            </div>
                            <div class="accord-content {{ $index === 0 ? 'collapsed' : '' }}" style="{{ $index === 0 ? 'display: block;' : '' }}">
                                <div class="accord-content-inner">
                                    <p>{!! nl2br(e($item->answer)) !!}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-white rounded border text-center text-muted">
                            <i class="fa fa-info-circle fa-2x mb-2 text-muted"></i>
                            <p class="mb-0">Belum ada pertanyaan FAQ yang dipublikasikan.</p>
                        </div>
                    @endforelse

                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR BANTUAN & TAUTAN CEPAT --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="wow fadeInRight" data-wow-delay="0.2s">
                    
                    {{-- KARTU HELPDESK RESMI --}}
                    <div class="sifit-card-standard" style="padding: 22px; margin-bottom: 20px; border-top: 4px solid var(--sifit-primary); background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                            <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" style="height: 38px; object-fit: contain;">
                            <div>
                                <h3 style="margin: 0; font-size: 15.5px; font-weight: 800; color: var(--sifit-primary);">Pusat Layanan SIFIT</h3>
                                <span style="font-size: 11.5px; color: #64748b; font-weight: 600;">{{ $siteSettings['tentang_instansi'] ?? 'Dinas Kesehatan Provinsi Riau' }}</span>
                            </div>
                        </div>

                        <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 16px;">
                            Punya pertanyaan lain atau memerlukan bantuan teknis terkait data kefarmasian? Tim kami siap melayani Anda.
                        </p>

                        <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 18px;">
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #334155; background: #f8fafc; padding: 7px 12px; border-radius: 6px;">
                                <i class="fa fa-clock-o" style="color: var(--sifit-primary); font-size: 13px;"></i>
                                <span>{{ $siteSettings['kontak_jam_layanan'] ?? 'Senin - Jumat: 08:00 - 16:00 WIB' }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #334155; background: #f8fafc; padding: 7px 12px; border-radius: 6px;">
                                <i class="fa fa-phone" style="color: var(--sifit-primary); font-size: 13px;"></i>
                                <span>{{ $siteSettings['kontak_telepon'] ?? '0761-23547 / Dinkes Riau' }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; color: #334155; background: #f8fafc; padding: 7px 12px; border-radius: 6px;">
                                <i class="fa fa-map-marker" style="color: var(--sifit-primary); font-size: 13px;"></i>
                                <span>{{ $siteSettings['kontak_alamat'] ?? 'Jl. Cut Nyak Dien No. 03, Pekanbaru' }}</span>
                            </div>
                        </div>

                        <a href="{{ route('frontend.contact') }}" class="thm-btn" style="width: 100%; text-align: center; padding: 9px 16px; font-size: 12.5px; display: block; text-decoration: none; border-radius: 4px;">
                            <i class="fa fa-envelope"></i> Kirim Pertanyaan / Pengaduan
                        </a>
                    </div>

                    {{-- KARTU TAUTAN CEPAT --}}
                    <div class="sifit-card-standard" style="padding: 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <h4 style="margin: 0 0 12px 0; font-size: 14.5px; font-weight: 800; color: var(--sifit-primary); display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-link" style="color: var(--sifit-accent);"></i> Layanan Terkait
                        </h4>
                        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 6px;">
                            <li>
                                <a href="{{ route('frontend.galeri') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f8fafc; border-radius: 6px; color: #334155; font-size: 12.5px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;">
                                    <span><i class="fa fa-picture-o" style="color: var(--sifit-primary); margin-right: 8px;"></i> Galeri Foto & Video</span>
                                    <i class="fa fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.informasi-obat') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f8fafc; border-radius: 6px; color: #334155; font-size: 12.5px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;">
                                    <span><i class="fa fa-book" style="color: var(--sifit-primary); margin-right: 8px;"></i> Panduan Penggunaan Obat</span>
                                    <i class="fa fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.about') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f8fafc; border-radius: 6px; color: #334155; font-size: 12.5px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;">
                                    <span><i class="fa fa-info-circle" style="color: var(--sifit-primary); margin-right: 8px;"></i> Profil & Visi Misi SIFIT</span>
                                    <i class="fa fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.berita') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f8fafc; border-radius: 6px; color: #334155; font-size: 12.5px; font-weight: 600; text-decoration: none; transition: all 0.2s ease;">
                                    <span><i class="fa fa-newspaper-o" style="color: var(--sifit-primary); margin-right: 8px;"></i> Berita & Informasi Farmasi</span>
                                    <i class="fa fa-chevron-right" style="font-size: 10px; color: #94a3b8;"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>
@endsection
