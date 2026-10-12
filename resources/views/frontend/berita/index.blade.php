@extends('frontend.layouts.app')
@section('title', 'Berita & Informasi - SIFIT Provinsi Riau')

@section('content')
<style>
    .sifit-news-section {
        padding: 28px 0 50px;
        background: #f8fafc;
    }
    .sifit-news-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .sifit-news-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(17, 85, 102, 0.1);
        border-color: rgba(77, 182, 172, 0.7);
    }
    .sifit-news-thumb {
        width: 100%;
        height: 180px;
        overflow: hidden;
        background: linear-gradient(135deg, #0b3a46, #115566);
        position: relative;
    }
    .sifit-news-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .sifit-news-card:hover .sifit-news-thumb img {
        transform: scale(1.05);
    }
    /* Unified Sidebar */
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
        margin-bottom: 16px;
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
    .sifit-cat-pill {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 6px;
        color: #334155;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-bottom: 6px;
    }
    .sifit-cat-pill:hover,
    .sifit-cat-pill.active {
        background: var(--sifit-primary);
        color: #ffffff;
        border-color: var(--sifit-primary);
        padding-left: 14px;
    }
    .sifit-cat-pill.active i,
    .sifit-cat-pill:hover i {
        color: var(--sifit-accent);
    }
    @media (max-width: 767px) {
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
                <h1><i class="fa fa-newspaper-o" style="color: var(--sifit-accent);"></i> Berita & Informasi Publik</h1>
                <p>Warta kesehatan, regulasi farmasi, dan siaran pers resmi Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Berita & Informasi</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- DAFTAR ARTIKEL BERITA --}}
<section class="sifit-news-section">
    <div class="container">
        <div class="row">

            {{-- KONTEN UTAMA --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                {{-- Status Filter Aktif --}}
                @if(request('search') || request('category'))
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-left: 4px solid var(--sifit-primary); border-radius: 6px; padding: 10px 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;" class="wow fadeInDown" data-wow-delay="0.05s">
                        <span style="font-size: 13px; color: #334155;">
                            <i class="fa fa-filter" style="color: var(--sifit-primary); margin-right: 6px;"></i>
                            Filter: <strong>{{ request('search') ? '"'.request('search').'"' : 'Kategori Terpilih' }}</strong>
                        </span>
                        <a href="{{ route('frontend.berita') }}" style="color: #ef4444; font-size: 12px; font-weight: 700; text-decoration: none;">
                            <i class="fa fa-times"></i> Reset Filter
                        </a>
                    </div>
                @endif

                <div class="row" style="display: flex; flex-wrap: wrap;">
                    @forelse($news as $index => $item)
                        @php
                            $hasValidImage = $item->image && file_exists(public_path('storage/' . $item->image));
                            $thumbSrc = $hasValidImage ? asset('storage/' . $item->image) : asset('assets/images/news-default.svg');
                            $plainExcerpt = trim(html_entity_decode(strip_tags(str_replace('&nbsp;', ' ', $item->content))));
                            $delay = 0.05 + (($index % 4) * 0.08);
                        @endphp
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="{{ $delay }}s" style="display: flex; margin-bottom: 20px;">
                            <div class="sifit-news-card" style="width: 100%;">
                                <div class="sifit-news-thumb">
                                    <img
                                        src="{{ $thumbSrc }}"
                                        alt="{{ $item->title }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                    >
                                    <span style="position: absolute; top: 10px; left: 10px; background: rgba(11, 58, 70, 0.9); color: #ffffff; padding: 3px 8px; border-radius: 4px; font-size: 10.5px; font-weight: 700; letter-spacing: 0.3px;">
                                        {{ $item->category ? $item->category->name : 'Informasi' }}
                                    </span>
                                </div>

                                <div style="padding: 16px; flex: 1; display: flex; flex-direction: column;">
                                    <div style="display: flex; align-items: center; gap: 12px; font-size: 11.5px; color: #64748b; margin-bottom: 8px;">
                                        <span><i class="fa fa-calendar-o" style="color: var(--sifit-primary); margin-right: 4px;"></i> {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : $item->created_at->format('d M Y') }}</span>
                                        <span><i class="fa fa-shield" style="color: var(--sifit-primary); margin-right: 4px;"></i> {{ $item->user ? $item->user->name : 'Dinas Kesehatan' }}</span>
                                    </div>

                                    <h3 style="font-size: 15px; font-weight: 800; margin: 0 0 8px; line-height: 1.35;">
                                        <a href="{{ route('frontend.berita.detail', $item->slug) }}" style="color: #1e293b; text-decoration: none; transition: color 0.2s ease;">
                                            {{ $item->title }}
                                        </a>
                                    </h3>

                                    <p style="color: #64748b; font-size: 12.5px; line-height: 1.55; margin: 0 0 14px;">
                                        {{ \Illuminate\Support\Str::limit($plainExcerpt, 100) }}
                                    </p>

                                    <div style="margin-top: auto; padding-top: 12px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                                        <a href="{{ route('frontend.berita.detail', $item->slug) }}" style="color: var(--sifit-primary); font-size: 12.5px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                            Baca Selengkapnya <i class="fa fa-arrow-right"></i>
                                        </a>
                                        @if($item->pdf_file)
                                            <span style="background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 2px 7px; border-radius: 4px; font-size: 10.5px; font-weight: 700;">
                                                <i class="fa fa-file-pdf-o"></i> PDF
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 40px 20px; text-align: center;">
                                <i class="fa fa-newspaper-o" style="font-size: 36px; color: #94a3b8; margin-bottom: 12px;"></i>
                                <h3 style="color: var(--sifit-primary); font-weight: 800; margin-bottom: 6px; font-size: 16px;">Belum Ada Berita</h3>
                                <p style="color: #64748b; font-size: 13px; margin: 0;">Tidak ada artikel atau berita yang sesuai dengan filter pencarian ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINASI --}}
                @if($news->hasPages())
                    <div style="margin-top: 20px; text-align: center;">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>

            {{-- SIDEBAR BERITA TUNGGAL (Unified Single Card) --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="sifit-sidebar-unified wow fadeInRight" data-wow-delay="0.1s">
                    
                    {{-- CARI BERITA --}}
                    <h4 class="sidebar-title">
                        <i class="fa fa-search" style="color: var(--sifit-accent);"></i> Cari Berita
                    </h4>
                    <form action="{{ route('frontend.berita') }}" method="GET">
                        <div class="sifit-sidebar-search-box">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Kata kunci warta..."
                            >
                            <button type="submit" title="Cari">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="sifit-sidebar-divider"></div>

                    {{-- KATEGORI WARTA --}}
                    <h4 class="sidebar-title">
                        <i class="fa fa-folder-open" style="color: var(--sifit-accent);"></i> Kategori Warta
                    </h4>
                    <div style="margin-bottom: 16px;">
                        <a href="{{ route('frontend.berita') }}" class="sifit-cat-pill {{ !request('category') ? 'active' : '' }}">
                            <span>Semua Berita</span>
                            <i class="fa fa-chevron-right" style="font-size: 10px;"></i>
                        </a>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <a href="{{ route('frontend.berita', ['category' => $category->id]) }}" class="sifit-cat-pill {{ request('category') == $category->id ? 'active' : '' }}">
                                    <span>{{ $category->name }}</span>
                                    <i class="fa fa-chevron-right" style="font-size: 10px;"></i>
                                </a>
                            @endforeach
                        @endif
                    </div>

                    <div class="sifit-sidebar-divider"></div>

                    {{-- PPID RESMI --}}
                    <div style="background: #f0fdfa; border: 1px solid #99f6e4; border-radius: 6px; padding: 12px; font-size: 11.5px; color: #0f766e; line-height: 1.45;">
                        <div style="display: flex; align-items: flex-start; gap: 8px;">
                            <i class="fa fa-shield" style="font-size: 15px; color: var(--sifit-primary); margin-top: 1px;"></i>
                            <div>
                                <strong style="color: var(--sifit-primary); display: block; margin-bottom: 2px;">Kanal Publikasi Resmi</strong>
                                Dikelola oleh PPID Kefarmasian Dinas Kesehatan Provinsi Riau.
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection