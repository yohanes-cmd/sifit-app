@extends('frontend.layouts.app')
@section('title', 'Galeri - SIFIT Provinsi Riau')

@section('content')
<style>
    .sifit-gallery-section {
        padding: 40px 0 60px;
        background: #f8fafc;
    }
    .sifit-filter-nav {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 35px;
        flex-wrap: wrap;
    }
    .sifit-filter-btn {
        padding: 8px 22px;
        border-radius: 30px;
        font-size: 13.5px;
        font-weight: 700;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        text-decoration: none;
        transition: all 0.25s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .sifit-filter-btn:hover {
        border-color: var(--sifit-primary);
        color: var(--sifit-primary);
        transform: translateY(-2px);
    }
    .sifit-filter-btn.active {
        background: var(--sifit-primary);
        border-color: var(--sifit-primary);
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.25);
    }
    .sifit-gal-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(17, 85, 102, 0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .sifit-gal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 24px rgba(17, 85, 102, 0.1);
        border-color: rgba(77, 182, 172, 0.6);
    }
    .sifit-gal-media {
        height: 220px;
        position: relative;
        overflow: hidden;
        background: #0f172a;
        display: block;
        text-decoration: none;
    }
    .sifit-gal-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .sifit-gal-card:hover .sifit-gal-img {
        transform: scale(1.05);
    }
    .sifit-gal-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        z-index: 2;
    }
    .sifit-badge-photo {
        background: rgba(17, 85, 102, 0.9);
        backdrop-filter: blur(4px);
    }
    .sifit-badge-video {
        background: rgba(220, 38, 38, 0.9);
        backdrop-filter: blur(4px);
    }
    .sifit-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        background: rgba(220, 38, 38, 0.9);
        border-radius: 50%;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.35);
        transition: transform 0.3s ease, background 0.3s ease;
    }
    .sifit-gal-card:hover .sifit-play-icon {
        transform: translate(-50%, -50%) scale(1.1);
        background: #dc2626;
    }
    .sifit-gal-body {
        padding: 18px 20px 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .sifit-gal-title {
        font-size: 15.5px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 10px;
        line-height: 1.45;
    }
    .sifit-gal-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .sifit-gal-title a:hover {
        color: var(--sifit-primary);
    }
    .sifit-gal-desc {
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
        margin: 0 0 16px;
    }
    .sifit-gal-footer {
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sifit-gal-date {
        font-size: 11.5px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .sifit-gal-detail-btn {
        font-size: 12px;
        font-weight: 700;
        color: var(--sifit-primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color 0.2s, transform 0.2s;
    }
    .sifit-gal-detail-btn:hover {
        color: var(--sifit-accent);
        transform: translateX(3px);
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-picture-o" style="color: var(--sifit-accent);"></i> Galeri</h1>
                <p>Dokumentasi foto dan video pelayanan kefarmasian Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Galeri</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KONTEN GALERI --}}
<section class="sifit-gallery-section">
    <div class="container">

        {{-- FILTER TABS (Diringkas: Semua, Foto, Video) --}}
        <div class="sifit-filter-nav wow fadeInUp" data-wow-delay="0.1s">
            <a href="{{ route('frontend.galeri') }}" class="sifit-filter-btn {{ empty($type) ? 'active' : '' }}">
                <i class="fa fa-th"></i> Semua ({{ $totalAll }})
            </a>
            <a href="{{ route('frontend.galeri', ['type' => 'photo']) }}" class="sifit-filter-btn {{ $type === 'photo' ? 'active' : '' }}">
                <i class="fa fa-camera"></i> Foto ({{ $totalPhoto }})
            </a>
            <a href="{{ route('frontend.galeri', ['type' => 'video']) }}" class="sifit-filter-btn {{ $type === 'video' ? 'active' : '' }}">
                <i class="fa fa-video-camera"></i> Video ({{ $totalVideo }})
            </a>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            @forelse($galleries as $item)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.15s" style="display: flex; margin-bottom: 30px;">
                    <div class="sifit-gal-card" style="width: 100%;">

                        {{-- MEDIA DISPLAY --}}
                        <a href="{{ route('frontend.galeri.show', $item) }}" class="sifit-gal-media">
                            @if($item->type === 'photo')
                                <span class="sifit-gal-badge sifit-badge-photo">
                                    <i class="fa fa-camera"></i> Foto
                                </span>
                                <img
                                    src="{{ $item->media_url }}"
                                    alt="{{ $item->title }}"
                                    class="sifit-gal-img"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                >
                            @else
                                <span class="sifit-gal-badge sifit-badge-video">
                                    <i class="fa fa-video-camera"></i> Video
                                </span>
                                <img
                                    src="{{ $item->media_url }}"
                                    alt="{{ $item->title }}"
                                    class="sifit-gal-img"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                >
                                <div class="sifit-play-icon">
                                    <i class="fa fa-play" style="margin-left: 3px;"></i>
                                </div>
                            @endif
                        </a>

                        {{-- KONTEN BODY --}}
                        <div class="sifit-gal-body">
                            <h3 class="sifit-gal-title">
                                <a href="{{ route('frontend.galeri.show', $item) }}">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            @if($item->description)
                                <p class="sifit-gal-desc">{{ Str::limit($item->description, 120) }}</p>
                            @endif

                            <div class="sifit-gal-footer">
                                <div class="sifit-gal-date">
                                    <i class="fa fa-calendar-o"></i>
                                    <span>{{ $item->created_at ? $item->created_at->translatedFormat('d F Y') : 'Baru saja' }}</span>
                                </div>

                                <a href="{{ route('frontend.galeri.show', $item) }}" class="sifit-gal-detail-btn">
                                    Lihat Detail <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 60px 20px; text-align: center;">
                        <div style="width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #f0fdfa; color: #115566; font-size: 28px; margin: 0 auto 15px;">
                            <i class="fa fa-picture-o"></i>
                        </div>
                        <h3 style="color: #115566; font-weight: 700; margin-bottom: 8px;">Belum Ada Dokumentasi Kegiatan</h3>
                        <p style="color: #64748b; font-size: 13.5px; max-width: 480px; margin: 0 auto;">
                            Dokumentasi foto dan video kegiatan instalasi farmasi SIFIT sedang dalam proses pembaruan oleh pengelola.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- PAGINASI --}}
        @if(method_exists($galleries, 'hasPages') && $galleries->hasPages())
            <div style="margin-top: 25px; text-align: center;">
                {{ $galleries->links() }}
            </div>
        @endif

    </div>
</section>
@endsection
