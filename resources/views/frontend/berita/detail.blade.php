@extends('frontend.layouts.app')
@section('title', $news->title . ' - Berita & Informasi SIFIT')

@section('content')
<style>
    .sifit-news-detail-section {
        padding: 28px 0 50px;
        background: #f8fafc;
    }
    .sifit-article-container {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 24px 28px;
        box-shadow: 0 4px 16px rgba(17, 85, 102, 0.04);
        transition: box-shadow 0.3s ease;
    }
    .sifit-article-hero-img {
        width: 100%;
        max-height: 380px;
        border-radius: 8px;
        overflow: hidden;
        margin: 16px 0 22px 0;
        background: linear-gradient(135deg, #0b3a46, #115566);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    }
    .sifit-article-hero-img img {
        width: 100%;
        max-height: 380px;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .sifit-article-hero-img:hover img {
        transform: scale(1.02);
    }
    .sifit-article-body {
        color: #334155;
        font-size: 15px;
        line-height: 1.8;
        word-break: break-word;
    }
    .sifit-article-body p {
        margin-bottom: 16px;
    }
    .sifit-article-body img {
        max-width: 100% !important;
        height: auto !important;
        border-radius: 8px;
        margin: 14px 0;
    }
    .sifit-article-body blockquote {
        border-left: 4px solid var(--sifit-primary);
        background: #f0fdfa;
        padding: 12px 16px;
        margin: 16px 0;
        border-radius: 0 8px 8px 0;
        font-style: italic;
        color: #0f766e;
    }
    .sifit-article-meta-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12.5px;
        color: #64748b;
    }
    .sifit-meta-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f1f5f9;
        color: #475569;
        padding: 3px 10px;
        border-radius: 16px;
        font-size: 11.5px;
        font-weight: 600;
    }
    .sifit-meta-pill-cat {
        background: rgba(17, 85, 102, 0.1);
        color: var(--sifit-primary);
        border: 1px solid rgba(17, 85, 102, 0.2);
    }
    .sifit-meta-pill-verified {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    
    /* Single Unified Sidebar */
    .sifit-sidebar-unified {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.04);
        position: sticky;
        top: 80px;
    }
    .sifit-sidebar-unified .sidebar-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--sifit-primary);
        margin: 0 0 12px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sifit-sidebar-search-box {
        position: relative;
        margin-bottom: 18px;
    }
    .sifit-sidebar-search-box input {
        width: 100%;
        height: 38px;
        padding: 6px 40px 6px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 13px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .sifit-sidebar-search-box input:focus {
        border-color: var(--sifit-accent);
        box-shadow: 0 0 0 3px rgba(77, 182, 172, 0.15);
        outline: none;
    }
    .sifit-sidebar-search-box button {
        position: absolute;
        right: 4px;
        top: 4px;
        bottom: 4px;
        width: 32px;
        background: var(--sifit-primary);
        color: #ffffff;
        border: none;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .sifit-sidebar-search-box button:hover {
        background: var(--sifit-primary-dark);
    }
    .sifit-sidebar-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 16px 0;
    }
    .sifit-related-item {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s ease;
        text-decoration: none !important;
        margin-bottom: 8px;
    }
    .sifit-related-item:hover {
        background: #f0fdfa;
        transform: translateX(4px);
    }
    .sifit-related-item:last-child {
        margin-bottom: 0;
    }
    .sifit-share-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .sifit-share-wa {
        background: #25D366;
        color: #ffffff !important;
    }
    .sifit-share-wa:hover {
        background: #1eb954;
        transform: translateY(-1px);
    }
    .sifit-share-copy {
        background: #f1f5f9;
        color: #334155 !important;
        border: 1px solid #cbd5e1;
    }
    .sifit-share-copy:hover {
        background: #e2e8f0;
        transform: translateY(-1px);
    }
    @media (max-width: 767px) {
        .sifit-article-container {
            padding: 16px 14px;
        }
        .sifit-sidebar-unified {
            margin-top: 24px;
            position: static;
        }
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-newspaper-o" style="color: var(--sifit-accent);"></i> Warta & Siaran Resmi</h1>
                <p>Publikasi informasi kefarmasian dan kesehatan Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.berita') }}">Berita</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ Str::limit($news->title, 25) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- DETAIL BERITA UTAMA --}}
<section class="sifit-news-detail-section">
    <div class="container">
        <div class="row">

            {{-- ARTIKEL UTAMA (1 Single Clean Card) --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="sifit-article-container wow fadeInUp" data-wow-delay="0.1s">

                    {{-- METADATA BARIS ATAS --}}
                    <div class="sifit-article-meta-row">
                        <span class="sifit-meta-pill sifit-meta-pill-cat">
                            <i class="fa fa-folder-open"></i> {{ $news->category ? $news->category->name : 'Informasi Farmasi' }}
                        </span>
                        <span class="sifit-meta-pill sifit-meta-pill-verified">
                            <i class="fa fa-check-circle"></i> Rilis Resmi Dinkes Riau
                        </span>
                        <span style="margin-left: auto; font-size: 12px; color: #64748b;">
                            <i class="fa fa-calendar-o" style="color: var(--sifit-primary); margin-right: 4px;"></i>
                            {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->translatedFormat('l, d F Y') : $news->created_at->translatedFormat('l, d F Y') }}
                        </span>
                    </div>

                    {{-- JUDUL BERITA --}}
                    <h1 style="font-size: 22px; font-weight: 800; color: #1e293b; margin: 14px 0 12px; line-height: 1.35; letter-spacing: -0.3px;">
                        {{ $news->title }}
                    </h1>

                    {{-- PENULIS / PENERBIT --}}
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 14px; display: flex; align-items: center; gap: 6px;">
                        <i class="fa fa-user-circle" style="color: var(--sifit-primary);"></i>
                        Diterbitkan oleh: <strong>{{ $news->user ? $news->user->name : 'Dinas Kesehatan Provinsi Riau' }}</strong>
                    </div>

                    {{-- GAMBAR UTAMA BERITA --}}
                    @php
                        $detailThumb = ($news->image && file_exists(public_path('storage/'.$news->image))) ? asset('storage/'.$news->image) : asset('assets/images/news-default.svg');
                    @endphp
                    <div class="sifit-article-hero-img">
                        <img src="{{ $detailThumb }}" alt="{{ $news->title }}" onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';">
                    </div>

                    {{-- ISI KONTEN BERITA --}}
                    <div class="sifit-article-body">
                        {!! $news->content !!}
                    </div>

                    {{-- LAMPIRAN DOKUMEN RESMI (PDF) --}}
                    @if($news->pdf_file)
                        <div style="margin-top: 24px; padding: 14px 18px; background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #dc2626; border-radius: 6px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fa fa-file-pdf-o" style="font-size: 26px; color: #dc2626;"></i>
                                <div>
                                    <strong style="color: #991b1b; display: block; font-size: 13px;">Lampiran Dokumen Resmi (PDF)</strong>
                                    <span style="color: #64748b; font-size: 12px;">Salinan resmi siaran pers / surat edaran</span>
                                </div>
                            </div>
                            <a href="{{ asset('storage/'.$news->pdf_file) }}" target="_blank" class="thm-btn" style="background: #dc2626 !important; border-color: #dc2626 !important; padding: 7px 16px; font-size: 12px; font-weight: 700; text-decoration: none; border-radius: 4px;">
                                <i class="fa fa-download" style="margin-right: 5px;"></i> Unduh PDF
                            </a>
                        </div>
                    @endif

                    {{-- FOOTER ARTIKEL: BAGIKAN & KEMBALI --}}
                    <div style="margin-top: 26px; padding-top: 16px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                            <span style="font-size: 12.5px; font-weight: 700; color: #475569;">
                                <i class="fa fa-share-alt"></i> Bagikan:
                            </span>
                            <a href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' - ' . url()->current()) }}" target="_blank" class="sifit-share-btn sifit-share-wa">
                                <i class="fa fa-whatsapp"></i> WhatsApp
                            </a>
                            <button onclick="navigator.clipboard.writeText(window.location.href); Swal.fire({ icon: 'success', title: 'Tautan Disalin!', text: 'Tautan berita berhasil disalin ke clipboard.', timer: 2000, showConfirmButton: false, timerProgressBar: true });" class="sifit-share-btn sifit-share-copy">
                                <i class="fa fa-copy"></i> Salin Tautan
                            </button>
                        </div>

                        <a href="{{ route('frontend.berita') }}" style="color: var(--sifit-primary); font-size: 12.5px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa fa-arrow-left"></i> Kembali ke Warta
                        </a>
                    </div>

                    {{-- VERIFIKASI INSTANSI RESMI --}}
                    <div style="margin-top: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 16px; display: flex; align-items: center; gap: 12px;">
                        <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" style="height: 36px; object-fit: contain;">
                        <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
                            <strong style="color: #1e293b; display: block; font-size: 12.5px;">Dinas Kesehatan Pemerintah Provinsi Riau</strong>
                            Informasi resmi diterbitkan melalui Pengelola Informasi dan Dokumentasi Kefarmasian SIFIT.
                        </div>
                    </div>

                </div>
            </div>

            {{-- SIDEBAR TUNGGAL (1 Single Unified Card) --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="sifit-sidebar-unified wow fadeInRight" data-wow-delay="0.15s">
                    
                    {{-- PENCARIAN --}}
                    <h4 class="sidebar-title">
                        <i class="fa fa-search" style="color: var(--sifit-accent);"></i> Cari Warta
                    </h4>
                    <form action="{{ route('frontend.berita') }}" method="GET">
                        <div class="sifit-sidebar-search-box">
                            <input
                                name="search"
                                placeholder="Kata kunci warta..."
                                type="text"
                                value="{{ request('search') }}"
                            >
                            <button type="submit" title="Cari">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="sifit-sidebar-divider"></div>

                    {{-- WARTA TERBARU LAINNYA --}}
                    <h4 class="sidebar-title">
                        <i class="fa fa-newspaper-o" style="color: var(--sifit-accent);"></i> Warta Terbaru
                    </h4>

                    <div style="display: flex; flex-direction: column;">
                        @forelse($latestNews as $latest)
                            @php
                                $latThumb = ($latest->image && file_exists(public_path('storage/' . $latest->image))) ? asset('storage/' . $latest->image) : asset('assets/images/news-default.svg');
                            @endphp
                            <a href="{{ route('frontend.berita.detail', $latest->slug) }}" class="sifit-related-item">
                                <div style="width: 60px; height: 48px; border-radius: 4px; overflow: hidden; background: #0f172a; flex-shrink: 0;">
                                    <img
                                        src="{{ $latThumb }}"
                                        alt="{{ $latest->title }}"
                                        style="width: 100%; height: 100%; object-fit: cover;"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                    >
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <h5 style="font-size: 12.5px; font-weight: 700; margin: 0 0 3px; line-height: 1.35; color: #1e293b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $latest->title }}
                                    </h5>
                                    <span style="color: #94a3b8; font-size: 11px;">
                                        <i class="fa fa-calendar-o"></i> {{ $latest->published_at ? \Carbon\Carbon::parse($latest->published_at)->format('d M Y') : $latest->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <p style="color: #64748b; font-size: 12.5px; margin: 0;">Belum ada warta lainnya.</p>
                        @endforelse
                    </div>

                    <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                        <a href="{{ route('frontend.berita') }}" style="color: var(--sifit-primary); font-size: 12px; font-weight: 700; text-decoration: none;">
                            Semua Warta <i class="fa fa-arrow-right"></i>
                        </a>
                        <a href="{{ route('frontend.obat') }}" style="color: #0f766e; font-size: 12px; font-weight: 700; text-decoration: none;">
                            <i class="fa fa-medkit"></i> Katalog Obat
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection