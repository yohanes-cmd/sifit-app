@extends('frontend.layouts.app')
@section('title', $gallery->title . ' - Galeri SIFIT Provinsi Riau')

@section('content')
<style>
    .sifit-gallery-detail-section {
        padding: 35px 0 65px;
        background: #f8fafc;
    }
    .sifit-detail-main-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(17, 85, 102, 0.05);
        margin-bottom: 25px;
    }
    .sifit-detail-media-wrap {
        background: #0f172a;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sifit-detail-photo {
        width: 100%;
        max-height: 520px;
        object-fit: contain;
        display: block;
        background: #0b1329;
    }
    .sifit-detail-video-container {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        background: #000000;
    }
    .sifit-detail-video-container iframe,
    .sifit-detail-video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
    .sifit-detail-content {
        padding: 26px 30px 32px;
    }
    .sifit-detail-badges {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 14px;
        flex-wrap: wrap;
    }
    .sifit-badge-detail {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .sifit-badge-detail.photo {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }
    .sifit-badge-detail.video {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .sifit-detail-title {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.4;
        margin: 0 0 16px;
    }
    .sifit-detail-meta {
        display: flex;
        align-items: center;
        gap: 18px;
        padding-bottom: 16px;
        margin-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12.5px;
        color: #64748b;
        flex-wrap: wrap;
    }
    .sifit-detail-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .sifit-detail-desc {
        font-size: 14.5px;
        line-height: 1.8;
        color: #334155;
        margin-bottom: 24px;
        white-space: pre-line;
    }
    .sifit-share-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .sifit-share-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sifit-share-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        color: #ffffff;
        transition: transform 0.2s, opacity 0.2s;
    }
    .sifit-share-btn:hover {
        transform: translateY(-2px);
        opacity: 0.95;
        color: #ffffff;
    }
    .btn-share-wa {
        background: #25d366;
    }
    .btn-share-fb {
        background: #1877f2;
    }
    .btn-share-copy {
        background: #475569;
        border: none;
        cursor: pointer;
    }

    /* SIDEBAR */
    .sifit-detail-sidebar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 22px;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.04);
        position: sticky;
        top: 85px;
    }
    .sifit-sidebar-heading {
        font-size: 15px;
        font-weight: 800;
        color: var(--sifit-primary);
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sifit-related-item {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none;
        transition: transform 0.2s;
    }
    .sifit-related-item:last-child {
        border-bottom: none;
    }
    .sifit-related-item:hover {
        transform: translateX(3px);
    }
    .sifit-related-thumb {
        width: 80px;
        height: 60px;
        border-radius: 6px;
        overflow: hidden;
        background: #0f172a;
        flex-shrink: 0;
        position: relative;
    }
    .sifit-related-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .sifit-related-text {
        flex: 1;
        min-width: 0;
    }
    .sifit-related-title {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sifit-related-item:hover .sifit-related-title {
        color: var(--sifit-primary);
    }
    .sifit-related-date {
        font-size: 11px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>

{{-- BREADCRUMB --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-picture-o" style="color: var(--sifit-accent);"></i> Detail Dokumentasi Galeri</h1>
                <p>Dokumentasi resmi pelayanan kefarmasian Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.galeri') }}">Galeri</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ Str::limit($gallery->title, 25) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KONTEN DETAIL --}}
<section class="sifit-gallery-detail-section">
    <div class="container">
        <div class="row">

            {{-- KOLOM UTAMA --}}
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="sifit-detail-main-card">

                    {{-- MEDIA PLAYER / IMAGE --}}
                    <div class="sifit-detail-media-wrap">
                        @if($gallery->type === 'photo')
                            <img
                                src="{{ $gallery->media_url }}"
                                alt="{{ $gallery->title }}"
                                class="sifit-detail-photo"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                            >
                        @else
                            @if($gallery->youtube_embed_url)
                                <div class="sifit-detail-video-container">
                                    <iframe
                                        src="{{ $gallery->youtube_embed_url }}?autoplay=0&rel=0"
                                        title="{{ $gallery->title }}"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            @elseif($gallery->file_path)
                                <div class="sifit-detail-video-container">
                                    <video controls poster="{{ asset('assets/images/news-default.svg') }}">
                                        <source src="{{ asset('storage/' . $gallery->file_path) }}">
                                        Browser Anda tidak mendukung tag video.
                                    </video>
                                </div>
                            @else
                                <img
                                    src="{{ $gallery->media_url }}"
                                    alt="{{ $gallery->title }}"
                                    class="sifit-detail-photo"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                >
                            @endif
                        @endif
                    </div>

                    {{-- KONTEN DESKRIPSI --}}
                    <div class="sifit-detail-content">

                        <div class="sifit-detail-badges">
                            @if($gallery->type === 'photo')
                                <span class="sifit-badge-detail photo">
                                    <i class="fa fa-camera"></i> Dokumentasi Foto
                                </span>
                            @else
                                <span class="sifit-badge-detail video">
                                    <i class="fa fa-video-camera"></i> Dokumentasi Video
                                </span>
                            @endif

                            <span style="font-size: 11.5px; color: #94a3b8; margin-left: auto;">
                                ID: #GLR-{{ str_pad($gallery->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <h1 class="sifit-detail-title">{{ $gallery->title }}</h1>

                        <div class="sifit-detail-meta">
                            <div class="sifit-detail-meta-item">
                                <i class="fa fa-calendar-o" style="color: var(--sifit-accent);"></i>
                                <span>{{ $gallery->created_at ? $gallery->created_at->translatedFormat('l, d F Y - H:i') . ' WIB' : 'Waktu Baru' }}</span>
                            </div>
                            <div class="sifit-detail-meta-item">
                                <i class="fa fa-user-circle-o" style="color: var(--sifit-accent);"></i>
                                <span>{{ $gallery->user ? $gallery->user->name : 'Admin Farmasi' }}</span>
                            </div>
                            <div class="sifit-detail-meta-item">
                                <i class="fa fa-building-o" style="color: var(--sifit-accent);"></i>
                                <span>Dinas Kesehatan Provinsi Riau</span>
                            </div>
                        </div>

                        {{-- DESKRIPSI LENGKAP --}}
                        <div class="sifit-detail-desc">
                            @if($gallery->description)
                                {!! nl2br(e($gallery->description)) !!}
                            @else
                                <p class="text-muted" style="font-style: italic;">
                                    Tidak ada catatan deskripsi tambahan untuk dokumentasi kegiatan ini.
                                </p>
                            @endif
                        </div>

                        @if($gallery->type === 'video' && $gallery->youtube_url)
                            <div style="margin-bottom: 22px;">
                                <a href="{{ $gallery->youtube_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm" style="background: #dc2626; color: #ffffff; font-weight: 700; border-radius: 6px; padding: 7px 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                                    <i class="fa fa-youtube-play"></i> Tonton Langsung di YouTube <i class="fa fa-external-link" style="font-size: 11px;"></i>
                                </a>
                            </div>
                        @endif

                        {{-- BAGIKAN & KEMBALI --}}
                        <div class="sifit-share-bar">
                            <a href="{{ route('frontend.galeri') }}" class="btn btn-sm btn-default" style="font-size: 12px; font-weight: 700; border-radius: 6px; padding: 6px 14px; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fa fa-arrow-left"></i> Kembali ke Galeri
                            </a>

                            <div class="sifit-share-buttons">
                                <span style="font-size: 12px; color: #64748b; font-weight: 600; margin-right: 4px;">Bagikan:</span>
                                
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($gallery->title . ' - ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="sifit-share-btn btn-share-wa" title="Bagikan ke WhatsApp">
                                    <i class="fa fa-whatsapp"></i> WhatsApp
                                </a>

                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="sifit-share-btn btn-share-fb" title="Bagikan ke Facebook">
                                    <i class="fa fa-facebook"></i> Facebook
                                </a>

                                <button type="button" onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Tautan halaman galeri berhasil disalin!');" class="sifit-share-btn btn-share-copy" title="Salin Tautan">
                                    <i class="fa fa-link"></i> Salin Link
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- KOLOM SIDEBAR --}}
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="sifit-detail-sidebar">
                    
                    <h4 class="sifit-sidebar-heading">
                        <i class="fa fa-picture-o" style="color: var(--sifit-accent);"></i> Dokumentasi Lainnya
                    </h4>

                    <div style="margin-bottom: 20px;">
                        @forelse($relatedGalleries as $related)
                            <a href="{{ route('frontend.galeri.show', $related) }}" class="sifit-related-item">
                                <div class="sifit-related-thumb">
                                    <img
                                        src="{{ $related->media_url }}"
                                        alt="{{ $related->title }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                    >
                                    @if($related->type === 'video')
                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 22px; height: 22px; border-radius: 50%; background: rgba(220, 38, 38, 0.9); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                                            <i class="fa fa-play" style="margin-left: 1px;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="sifit-related-text">
                                    <h5 class="sifit-related-title">{{ $related->title }}</h5>
                                    <div class="sifit-related-date">
                                        <i class="fa fa-calendar-o"></i>
                                        <span>{{ $related->created_at ? $related->created_at->translatedFormat('d M Y') : 'Baru' }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p style="font-size: 12.5px; color: #94a3b8; font-style: italic;">
                                Belum ada dokumentasi lain yang tersedia.
                            </p>
                        @endforelse
                    </div>

                    <a href="{{ route('frontend.galeri') }}" class="btn btn-block" style="background: var(--sifit-primary); color: #ffffff; font-size: 12.5px; font-weight: 700; border-radius: 6px; padding: 10px; text-align: center; text-decoration: none;">
                        <i class="fa fa-th-large mr-1"></i> Telusuri Seluruh Galeri
                    </a>

                    <div style="margin-top: 22px; background: #f0fdfa; border: 1px solid #99f6e4; border-radius: 8px; padding: 14px; font-size: 12px; color: #0f766e; line-height: 1.5;">
                        <div style="display: flex; gap: 8px;">
                            <i class="fa fa-shield" style="font-size: 16px; color: var(--sifit-primary); margin-top: 1px;"></i>
                            <div>
                                <strong style="color: var(--sifit-primary); display: block; margin-bottom: 2px;">Publikasi Resmi</strong>
                                Dikelola langsung oleh UPT Instalasi Farmasi dan Pengelolaan Logistik Kesehatan Dinas Kesehatan Pemerintah Provinsi Riau.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
