@extends('frontend.layouts.app')
@section('title', 'Portal Resmi SIFIT - Sistem Informasi Farmasi Terintegrasi Provinsi Riau')

@section('content')

{{-- ==========================================================================
     1. HERO SECTION - PORTAL RESMI PEMERINTAH PROVINSI RIAU
     ========================================================================== --}}
<section class="sifit-hero-banner">
    <div class="container">
        <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">

            {{-- SISI KIRI: INTRODUKSI & PENCARIAN CEPAT --}}
            <div class="col-lg-7 col-md-7 col-sm-12">
                <div class="sifit-hero-left wow fadeInLeft" data-wow-duration="0.9s" data-wow-delay="0.1s">
                    <span class="sifit-hero-badge">
                        <i class="fa fa-shield"></i> Portal Resmi Dinas Kesehatan Provinsi Riau
                    </span>

                    <h1 class="sifit-hero-title">
                        Sistem Informasi Farmasi <span class="highlight">Terintegrasi</span> (SIFIT)
                    </h1>

                    <p class="sifit-hero-desc">
                        Layanan publik terpadu untuk ketersediaan obat, transparansi data kefarmasian, dan panduan kesehatan resmi bagi masyarakat dan fasilitas kesehatan Provinsi Riau.
                    </p>

                    {{-- SEARCH BOX DALAM HERO --}}
                    <div class="sifit-hero-search-wrapper">
                        <form action="{{ route('frontend.obat') }}" method="GET" class="sifit-hero-search-box">
                            <span class="search-icon"><i class="fa fa-search"></i></span>
                            <input
                                type="text"
                                name="search"
                                placeholder="Cari nama obat (cth: Paracetamol, Amoxicillin, Vitamin C)..."
                                autocomplete="off"
                            >
                            <button type="submit" class="sifit-hero-search-btn">
                                <span>Cari Obat</span>
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    {{-- TAG PENCARIAN POPULER --}}
                    <div class="sifit-hero-tags">
                        <span><i class="fa fa-fire"></i> Kategori Cepat:</span>
                        <a href="{{ route('frontend.obat', ['search' => 'Paracetamol']) }}" class="sifit-hero-tag">Paracetamol</a>
                        <a href="{{ route('frontend.obat', ['search' => 'Antibiotik']) }}" class="sifit-hero-tag">Antibiotik</a>
                        <a href="{{ route('frontend.obat', ['search' => 'Vitamin']) }}" class="sifit-hero-tag">Vitamin</a>
                        <a href="{{ route('frontend.obat', ['search' => 'Antasida']) }}" class="sifit-hero-tag">Antasida</a>
                    </div>
                </div>
            </div>

            {{-- SISI KANAN: KARTU IDENTITAS RESMI & STATISTIK SIFIT --}}
            <div class="col-lg-5 col-md-5 col-sm-12">
                <div class="sifit-hero-card wow fadeInRight" data-wow-duration="0.9s" data-wow-delay="0.2s">
                    <div class="sifit-hero-card-header">
                        <div class="sifit-hero-card-logo-badge">
                            <img src="{{ asset('assets/images/logo-sifit.png') }}" alt="Logo SIFIT" class="sifit-hero-card-logo">
                        </div>
                        <div class="sifit-hero-card-title">
                            <h3>SIFIT RIAU HEALTH HUB</h3>
                            <span>Instalasi Farmasi & Informasi Obat</span>
                        </div>
                    </div>

                    {{-- STATISTIK SINGKAT --}}
                    <div class="sifit-hero-stats-row">
                        <div class="sifit-hero-stat-pill">
                            <span class="sifit-hero-stat-num">{{ $latestProducts->count() }}+</span>
                            <span class="sifit-hero-stat-label">Obat Terdata</span>
                        </div>
                        <div class="sifit-hero-stat-pill">
                            <span class="sifit-hero-stat-num">{{ $latestNews->count() }}+</span>
                            <span class="sifit-hero-stat-label">Berita Terkini</span>
                        </div>
                        <div class="sifit-hero-stat-pill">
                            <span class="sifit-hero-stat-num">24/7</span>
                            <span class="sifit-hero-stat-label">Akses Terpadu</span>
                        </div>
                    </div>

                    {{-- TOMBOL TINDAKAN CEPAT --}}
                    <div class="sifit-hero-card-actions">
                        <a href="{{ route('frontend.obat') }}" class="sifit-btn-hero-primary">
                            <i class="fa fa-medkit"></i> Jelajahi Direktori & Katalog Obat
                        </a>
                        <a href="{{ route('frontend.obat.informasi') }}" class="sifit-btn-hero-outline">
                            <i class="fa fa-book"></i> Panduan Penggunaan Obat
                        </a>
                    </div>

                    <div class="sifit-hero-card-footer">
                        <i class="fa fa-check-circle"></i>
                        <span>Terverifikasi resmi Dinas Kesehatan Pemerintah Provinsi Riau</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ==========================================================================
     2. EMPAT PILAR LAYANAN UTAMA SIFIT
     ========================================================================== --}}
<section style="padding: 55px 0 45px; background: #ffffff;">
    <div class="container">
        <div class="sifit-section-header wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
            <span class="sifit-section-tag">Layanan Terpadu</span>
            <h2 class="sifit-section-title">Empat Pilar Utama Layanan SIFIT</h2>
            <p class="sifit-section-subtitle">Akses informasi dan fasilitas kefarmasian yang terstruktur dan terpercaya bagi masyarakat.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            {{-- PILAR 1: KATALOG OBAT --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.15s" style="display: flex; margin-bottom: 25px;">
                <div class="sifit-service-card">
                    <div class="sifit-service-icon-box">
                        <i class="fa fa-medkit"></i>
                    </div>
                    <h3>Direktori Obat</h3>
                    <p>Katalog data obat terpublikasi, mencakup kategori, ketentuan resep, stok, dan satuan resmi.</p>
                    <a href="{{ route('frontend.obat') }}" class="service-link">
                        Lihat Katalog <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- PILAR 2: EDUKASI PENGGUNAAN OBAT --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.25s" style="display: flex; margin-bottom: 25px;">
                <div class="sifit-service-card">
                    <div class="sifit-service-icon-box">
                        <i class="fa fa-book"></i>
                    </div>
                    <h3>Panduan Penggunaan Obat</h3>
                    <p>Edukasi tata cara mendapatkan, menggunakan, menyimpan, dan membuang obat secara aman.</p>
                    <a href="{{ route('frontend.obat.informasi') }}" class="service-link">
                        Baca Panduan <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- PILAR 3: BERITA & INFORMASI --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.35s" style="display: flex; margin-bottom: 25px;">
                <div class="sifit-service-card">
                    <div class="sifit-service-icon-box">
                        <i class="fa fa-newspaper-o"></i>
                    </div>
                    <h3>Berita & Informasi</h3>
                    <p>Publikasi berita terkini, kebijakan, edaran resmi, dan kegiatan kefarmasian di Riau.</p>
                    <a href="{{ route('frontend.berita') }}" class="service-link">
                        Lihat Berita <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- PILAR 4: KERANJANG & PERMINTAAN --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.45s" style="display: flex; margin-bottom: 25px;">
                <div class="sifit-service-card">
                    <div class="sifit-service-icon-box">
                        <i class="fa fa-shopping-basket"></i>
                    </div>
                    <h3>Keranjang Obat</h3>
                    <p>Layanan pemilihan dan pencatatan daftar obat yang dibutuhkan untuk kemudahan konsultasi.</p>
                    <a href="{{ route('frontend.cart.index') }}" class="service-link">
                        Buka Keranjang <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     3. DATA OBAT TERBARU (KATALOG UNGGULAN)
     ========================================================================== --}}
<section style="padding: 55px 0 50px; background: #f8fafc; border-top: 1px solid var(--sifit-border); border-bottom: 1px solid var(--sifit-border);">
    <div class="container">
        <div class="sifit-section-header wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
            <span class="sifit-section-tag">Katalog Obat</span>
            <h2 class="sifit-section-title">Ketersediaan & Data Obat Terbaru</h2>
            <p class="sifit-section-subtitle">Daftar obat resmi yang tercatat di sistem informasi farmasi Dinas Kesehatan Provinsi Riau.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            @forelse($latestProducts as $index => $product)
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s" style="display: flex; margin-bottom: 25px;">
                    <div class="sifit-card" style="width: 100%; display: flex; flex-direction: column; background: #ffffff; border: 1px solid var(--sifit-border); border-radius: 12px; overflow: hidden;">
                        
                        {{-- GAMBAR OBAT --}}
                        <div style="height: 180px; background: #f8fafc; padding: 14px; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #f1f5f9;">
                            @php
                                $homeProdThumb = ($product->image && file_exists(public_path('storage/'.$product->image))) ? asset('storage/'.$product->image) : asset('assets/images/product-default.svg');
                            @endphp
                            <img
                                src="{{ $homeProdThumb }}"
                                alt="{{ $product->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/product-default.svg') }}';"
                                style="max-width: 100%; max-height: 100%; object-fit: contain;"
                            >
                            <div style="position: absolute; top: 10px; left: 10px;">
                                @if($product->requires_prescription)
                                    <span class="sifit-badge-prescription" title="Wajib menyertakan resep dokter">
                                        <i class="fa fa-file-text-o"></i> Resep Dokter
                                    </span>
                                @else
                                    <span class="sifit-badge-otc" title="Obat bebas / dapat dibeli langsung">
                                        <i class="fa fa-check"></i> Bebas
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- KONTEN INFORMASI OBAT --}}
                        <div style="padding: 16px; flex: 1; display: flex; flex-direction: column;">
                            <span class="sifit-badge-cat" style="align-self: flex-start; margin-bottom: 8px;">
                                {{ $product->category ? $product->category->name : 'Farmasi Umum' }}
                            </span>

                            <h3 style="font-size: 15px; font-weight: 700; margin: 0 0 8px; line-height: 1.4; min-height: 42px;">
                                <a href="{{ route('frontend.obat.detail', $product->slug) }}" style="color: #1e293b; text-decoration: none;">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div style="margin-top: auto; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 12px;">
                                    <span style="font-size: 16px; font-weight: 800; color: #115566;">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                    <span style="font-size: 11.5px; color: #64748b; font-weight: 500;">
                                        Stok: {{ $product->stock ?? '-' }} {{ $product->unit ?? '' }}
                                    </span>
                                </div>

                                <div style="display: flex; gap: 6px;">
                                    <a href="{{ route('frontend.obat.detail', $product->slug) }}" class="btn-style-two" style="flex: 1; text-align: center; padding: 7px 10px; font-size: 12px; text-decoration: none; border-radius: 6px;">
                                        Detail
                                    </a>
                                    <form action="{{ route('frontend.cart.add', $product->id) }}" method="POST" style="flex: 1.3;">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-add-cart" style="width: 100%; justify-content: center; font-size: 12px; padding: 7px 10px; border-radius: 6px;">
                                            <i class="fa fa-shopping-basket"></i> + Keranjang
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center" style="padding: 40px 0;">
                    <div style="max-width: 450px; margin: 0 auto; padding: 30px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <i class="fa fa-info-circle" style="font-size: 36px; color: #94a3b8; margin-bottom: 12px;"></i>
                        <h4 style="font-size: 16px; font-weight: 700; color: #1e293b;">Belum Ada Data Obat</h4>
                        <p style="color: #64748b; font-size: 13px; margin: 0;">Data obat yang dipublikasikan akan muncul secara otomatis di katalog ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 20px;">
            <a href="{{ route('frontend.obat') }}" class="thm-btn" style="padding: 12px 30px; font-size: 14px; font-weight: 700;">
                <i class="fa fa-th-list"></i> Lihat Semua Katalog Obat
            </a>
        </div>
    </div>
</section>

{{-- ==========================================================================
     4. PANDUAN EDUKASI KESEHATAN DAGUSIBU (RESMI KEMENKES / SIFIT)
     ========================================================================== --}}
<section class="sifit-dagusibu-section">
    <div class="container">
        <div class="sifit-section-header wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
            <span class="sifit-section-tag">Edukasi Farmasi</span>
            <h2 class="sifit-section-title">Panduan Cerdas Pengelolaan & Penggunaan Obat</h2>
            <p class="sifit-section-subtitle">Pedoman resmi tata kelola obat yang benar untuk keamanan dan kesehatan keluarga Anda.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row">
            {{-- STEP 1: DAPATKAN --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.15s" style="margin-bottom: 20px;">
                <div class="sifit-step-card">
                    <span class="sifit-step-num">01</span>
                    <span class="sifit-step-badge">DAPATKAN</span>
                    <h4>Peroleh dari Sarana Resmi</h4>
                    <p>Dapatkan obat di sarana pelayanan kefarmasian berizin resmi seperti Apotek, Rumah Sakit, dan Puskesmas.</p>
                </div>
            </div>

            {{-- STEP 2: GUNAKAN --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.25s" style="margin-bottom: 20px;">
                <div class="sifit-step-card">
                    <span class="sifit-step-num">02</span>
                    <span class="sifit-step-badge">GUNAKAN</span>
                    <h4>Gunakan Sesuai Petunjuk</h4>
                    <p>Konsumsi obat sesuai dosis, aturan pakai, waktu yang tepat, dan instruksi dari dokter atau apoteker.</p>
                </div>
            </div>

            {{-- STEP 3: SIMPAN --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.35s" style="margin-bottom: 20px;">
                <div class="sifit-step-card">
                    <span class="sifit-step-num">03</span>
                    <span class="sifit-step-badge">SIMPAN</span>
                    <h4>Simpan dengan Benar</h4>
                    <p>Simpan obat dalam wadah aslinya, terhindar dari sinar matahari langsung, dan jauh dari jangkauan anak-anak.</p>
                </div>
            </div>

            {{-- STEP 4: BUANG --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.45s" style="margin-bottom: 20px;">
                <div class="sifit-step-card">
                    <span class="sifit-step-num">04</span>
                    <span class="sifit-step-badge">BUANG</span>
                    <h4>Buang Obat Rusak / Expired</h4>
                    <p>Hancurkan dan buang obat yang rusak atau telah kedaluwarsa dengan benar agar tidak disalahgunakan.</p>
                </div>
            </div>
        </div>

        <div class="text-center wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 15px;">
            <a href="{{ route('frontend.obat.informasi') }}" class="btn-style-two" style="padding: 10px 24px; font-size: 13px; font-weight: 700; text-decoration: none;">
                <i class="fa fa-book"></i> Baca Panduan Lengkap Penggunaan Obat
            </a>
        </div>
    </div>
</section>

{{-- ==========================================================================
     5. WARTA & BERITA FARMASI TERKINI
     ========================================================================== --}}
<section style="padding: 55px 0 45px; background: #ffffff;">
    <div class="container">
        <div class="sifit-section-header wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
            <span class="sifit-section-tag">Berita & Publikasi</span>
            <h2 class="sifit-section-title">Berita & Informasi Farmasi Terkini</h2>
            <p class="sifit-section-subtitle">Informasi terbaru, kebijakan kesehatan, dan publikasi resmi dari Dinas Kesehatan Provinsi Riau.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row">
            @forelse($latestNews as $index => $item)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="{{ 0.15 + ($index * 0.12) }}s" style="margin-bottom: 30px;">
                    <div class="single-blog-item" style="border: 1px solid var(--sifit-border); border-radius: 12px; overflow: hidden; background: #ffffff; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <div class="img-holder" style="height: 200px; overflow: hidden; position: relative;">
                            @php
                                $homeNewsThumb = ($item->image && file_exists(public_path('storage/'.$item->image))) ? asset('storage/'.$item->image) : asset('assets/images/news-default.svg');
                            @endphp
                            <img src="{{ $homeNewsThumb }}" alt="{{ $item->title }}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';">

                            <div class="overlay-style-one">
                                <div class="box">
                                    <div class="content">
                                        <a href="{{ route('frontend.berita.detail', $item->slug) }}">
                                            <span class="flaticon-plus-symbol"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-holder" style="padding: 20px;">
                            <ul class="meta-info" style="margin-bottom: 10px; display: flex; gap: 14px; list-style: none; padding: 0; font-size: 12px; color: #64748b;">
                                <li>
                                    <i class="fa fa-calendar" style="color: var(--sifit-accent);"></i>
                                    {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : $item->created_at->format('d M Y') }}
                                </li>
                                <li>
                                    <i class="fa fa-folder-open" style="color: var(--sifit-accent);"></i>
                                    {{ $item->category ? $item->category->name : 'Farmasi' }}
                                </li>
                            </ul>

                            <a href="{{ route('frontend.berita.detail', $item->slug) }}" style="text-decoration: none;">
                                <h3 class="blog-title" style="font-size: 16px; font-weight: 700; color: #1e293b; margin: 0 0 10px; line-height: 1.4; min-height: 44px;">
                                    {{ $item->title }}
                                </h3>
                            </a>

                            <div class="text" style="color: #64748b; font-size: 13px; line-height: 1.5; margin-bottom: 15px;">
                                <p style="margin: 0;">{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 105) }}</p>
                            </div>

                            <a href="{{ route('frontend.berita.detail', $item->slug) }}" style="color: var(--sifit-primary); font-weight: 700; font-size: 12.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                                Baca Selengkapnya <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center" style="padding: 30px 0;">
                    <p style="color: #64748b;">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 10px;">
            <a href="{{ route('frontend.berita') }}" class="btn-style-two" style="padding: 10px 24px; font-size: 13px; font-weight: 700; text-decoration: none;">
                <i class="fa fa-newspaper-o"></i> Lihat Semua Berita & Informasi
            </a>
        </div>
    </div>
</section>

{{-- ==========================================================================
     6. FITUR SIFIT & PENCARIAN TERPADU
     ========================================================================== --}}
<section style="padding: 40px 0 36px; background: #f8fafc; border-top: 1px solid var(--sifit-border);">
    <div class="container">
        {{-- SECTION HEADER --}}
        <div class="sifit-section-header wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s" style="margin-bottom: 24px;">
            <span class="sifit-section-tag">Keunggulan Layanan</span>
            <h2 class="sifit-section-title">Fitur & Keunggulan Sistem SIFIT</h2>
            <p class="sifit-section-subtitle">Layanan informasi farmasi berbasis data terverifikasi dan transparansi publik Pemerintah Provinsi Riau.</p>
            <div class="sifit-section-divider"></div>
        </div>

        {{-- 4 FITUR DALAM 4 KOLOM PRESISI (TINGGI SAMA RATA / EQUAL HEIGHT) --}}
        <div class="row" style="display: flex; flex-wrap: wrap;">
            {{-- ITEM 1 --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.1s" style="display: flex; margin-bottom: 16px;">
                <div class="sifit-feature-card-compact" style="background: #ffffff; border: 1px solid var(--sifit-border); border-radius: 10px; padding: 20px 18px; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div style="width: 42px; height: 42px; border-radius: 8px; background: #f0fdfa; color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 17px; margin-bottom: 12px; border: 1px solid rgba(77,182,172,0.3); flex-shrink: 0;">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <h4 style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin: 0 0 6px;">Data Terverifikasi</h4>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.55; margin: 0;">Informasi obat melalui alur validasi bertingkat sebelum dipublikasikan resmi.</p>
                </div>
            </div>

            {{-- ITEM 2 --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.18s" style="display: flex; margin-bottom: 16px;">
                <div class="sifit-feature-card-compact" style="background: #ffffff; border: 1px solid var(--sifit-border); border-radius: 10px; padding: 20px 18px; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div style="width: 42px; height: 42px; border-radius: 8px; background: #f0fdfa; color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 17px; margin-bottom: 12px; border: 1px solid rgba(77,182,172,0.3); flex-shrink: 0;">
                        <i class="fa fa-search"></i>
                    </div>
                    <h4 style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin: 0 0 6px;">Pencarian Cepat</h4>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.55; margin: 0;">Mencari nama obat, indikasi terapi, dan kategori farmasi secara instan.</p>
                </div>
            </div>

            {{-- ITEM 3 --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.26s" style="display: flex; margin-bottom: 16px;">
                <div class="sifit-feature-card-compact" style="background: #ffffff; border: 1px solid var(--sifit-border); border-radius: 10px; padding: 20px 18px; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div style="width: 42px; height: 42px; border-radius: 8px; background: #f0fdfa; color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 17px; margin-bottom: 12px; border: 1px solid rgba(77,182,172,0.3); flex-shrink: 0;">
                        <i class="fa fa-cubes"></i>
                    </div>
                    <h4 style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin: 0 0 6px;">Kategori Lengkap</h4>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.55; margin: 0;">Pengelompokan jenis obat mempermudah pencarian kebutuhan terapi.</p>
                </div>
            </div>

            {{-- ITEM 4 --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.34s" style="display: flex; margin-bottom: 16px;">
                <div class="sifit-feature-card-compact" style="background: #ffffff; border: 1px solid var(--sifit-border); border-radius: 10px; padding: 20px 18px; width: 100%; height: 100%; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: transform 0.2s ease, box-shadow 0.2s ease;">
                    <div style="width: 42px; height: 42px; border-radius: 8px; background: #f0fdfa; color: var(--sifit-primary); display: flex; align-items: center; justify-content: center; font-size: 17px; margin-bottom: 12px; border: 1px solid rgba(77,182,172,0.3); flex-shrink: 0;">
                        <i class="fa fa-shield"></i>
                    </div>
                    <h4 style="font-size: 14.5px; font-weight: 700; color: #1e293b; margin: 0 0 6px;">Transparansi Publik</h4>
                    <p style="font-size: 12.5px; color: #64748b; line-height: 1.55; margin: 0;">Akses informasi terbuka sesuai standar pelayanan publik pemerintahan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     7. HELPDESK & CALL TO ACTION (MENGGANTIKAN GAMBAR 210x60 / AWARDS LAMA)
     ========================================================================== --}}
<section class="sifit-helpdesk-banner">
    <div class="container">
        <div class="sifit-helpdesk-content wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
            <div class="sifit-helpdesk-info">
                <h2>Butuh Bantuan atau Informasi Layanan Farmasi?</h2>
                <p>
                    Hubungi tim helpdesk Dinas Kesehatan Provinsi Riau atau pelajari panduan dan pertanyaan umum terkait sistem informasi farmasi SIFIT.
                </p>
            </div>

            <div class="sifit-helpdesk-actions">
                <a href="{{ route('frontend.contact') }}" class="sifit-btn-helpdesk-primary">
                    <i class="fa fa-phone"></i> Hubungi Layanan Kontak
                </a>
                <a href="{{ route('frontend.about.faq') }}" class="sifit-btn-helpdesk-outline">
                    <i class="fa fa-question-circle"></i> Tanya Jawab (FAQ)
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
