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
                        {{ $siteSettings['beranda_hero_ringkasan'] ?? 'Portal resmi keterbukaan informasi kefarmasian, edukasi penggunaan obat yang aman (prinsip DAGUSIBU), berita kesehatan, dan dokumentasi penyaluran perbekalan farmasi Dinas Kesehatan Provinsi Riau.' }}
                    </p>

                    {{-- SEARCH BOX DALAM HERO (PENCARIAN BERITA & INFORMASI) --}}
                    <div class="sifit-hero-search-wrapper">
                        <form action="{{ route('frontend.berita') }}" method="GET" class="sifit-hero-search-box">
                            <span class="search-icon"><i class="fa fa-search"></i></span>
                            <input
                                type="text"
                                name="search"
                                placeholder="Cari informasi publik, berita, atau panduan kefarmasian..."
                                autocomplete="off"
                            >
                            <button type="submit" class="sifit-hero-search-btn">
                                <span>Cari Informasi</span>
                                <i class="fa fa-arrow-right"></i>
                            </button>
                        </form>
                    </div>

                    {{-- TAG PENCARIAN POPULER --}}
                    <div class="sifit-hero-tags">
                        <span><i class="fa fa-fire"></i> Info Populer:</span>
                        <a href="{{ route('frontend.informasi-obat') }}" class="sifit-hero-tag">Panduan DAGUSIBU</a>
                        <a href="{{ route('frontend.galeri') }}" class="sifit-hero-tag">Galeri Kegiatan</a>
                        <a href="{{ route('frontend.about.faq') }}" class="sifit-hero-tag">Tanya Jawab (FAQ)</a>
                        <a href="{{ route('frontend.contact') }}" class="sifit-hero-tag">Kontak Pengaduan</a>
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
                            <h3>SIFIT RIAU PORTAL</h3>
                            <span>{{ $siteSettings['tentang_instansi'] ?? 'Dinas Kesehatan Pemerintah Provinsi Riau' }}</span>
                        </div>
                    </div>

                    {{-- STATISTIK SINGKAT --}}
                    <div class="sifit-hero-stats-row">
                        <div class="sifit-hero-stat-pill">
                            <span class="sifit-hero-stat-num">{{ $latestNews->count() }}+</span>
                            <span class="sifit-hero-stat-label">Berita Terkini</span>
                        </div>
                        <div class="sifit-hero-stat-pill">
                            <span class="sifit-hero-stat-num">{{ $latestGalleries->count() }}+</span>
                            <span class="sifit-hero-stat-label">Galeri Media</span>
                        </div>
                        <div class="sifit-hero-stat-pill">
                            <span class="sifit-hero-stat-num">24/7</span>
                            <span class="sifit-hero-stat-label">Informasi Publik</span>
                        </div>
                    </div>

                    {{-- TOMBOL TINDAKAN CEPAT --}}
                    <div class="sifit-hero-card-actions">
                        <a href="{{ route('frontend.berita') }}" class="sifit-btn-hero-primary">
                            <i class="fa fa-newspaper-o"></i> Baca Berita & Informasi Terkini
                        </a>
                        <a href="{{ route('frontend.galeri') }}" class="sifit-btn-hero-outline">
                            <i class="fa fa-picture-o"></i> Lihat Galeri Kegiatan
                        </a>
                    </div>

                    <div class="sifit-hero-card-footer">
                        <i class="fa fa-check-circle"></i>
                        <span>{{ $siteSettings['tentang_motto'] ?? 'Mewujudkan Pelayanan Kesehatan Berdaya Saing, Transparan & Terpercaya' }}</span>
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
            {{-- PILAR 1: INFORMASI OBAT --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.15s" style="display: flex; margin-bottom: 25px;">
                <div class="sifit-service-card">
                    <div class="sifit-service-icon-box">
                        <i class="fa fa-medkit"></i>
                    </div>
                    <h3>Informasi & Panduan Obat</h3>
                    <p>Petunjuk resmi tata kelola obat, ketentuan resep, dan regulasi kefarmasian terstandarisasi.</p>
                    <a href="{{ route('frontend.informasi-obat') }}" class="service-link">
                        Baca Informasi <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- PILAR 2: EDUKASI PENGGUNAAN OBAT --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.25s" style="display: flex; margin-bottom: 25px;">
                <div class="sifit-service-card">
                    <div class="sifit-service-icon-box">
                        <i class="fa fa-book"></i>
                    </div>
                    <h3>Panduan DAGUSIBU</h3>
                    <p>Edukasi tata cara mendapatkan, menggunakan, menyimpan, dan membuang obat secara aman.</p>
                    <a href="{{ route('frontend.informasi-obat') }}" class="service-link">
                        Pelajari DAGUSIBU <i class="fa fa-arrow-right"></i>
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
                    <p>Publikasi warta terkini, kebijakan kesehatan, edaran resmi, dan kegiatan dinas di Riau.</p>
                    <a href="{{ route('frontend.berita') }}" class="service-link">
                        Lihat Berita <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- PILAR 4: GALERI KEGIATAN --}}
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0.45s" style="display: flex; margin-bottom: 25px;">
                <div class="sifit-service-card">
                    <div class="sifit-service-icon-box">
                        <i class="fa fa-picture-o"></i>
                    </div>
                    <h3>Galeri Kegiatan</h3>
                    <p>Dokumentasi visual kegiatan kefarmasian, monitoring obat, dan pelayanan publik daerah.</p>
                    <a href="{{ route('frontend.galeri') }}" class="service-link">
                        Buka Galeri <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==========================================================================
     3. GALERI DOKUMENTASI & PUBLIKASI (TERBARU)
     ========================================================================== --}}
<section style="padding: 55px 0 50px; background: #f8fafc; border-top: 1px solid var(--sifit-border); border-bottom: 1px solid var(--sifit-border);">
    <div class="container">
        <div class="sifit-section-header wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.1s">
            <span class="sifit-section-tag">Galeri Kegiatan</span>
            <h2 class="sifit-section-title">Dokumentasi & Galeri Kegiatan Terbaru</h2>
            <p class="sifit-section-subtitle">Dokumentasi foto dan video rangkaian pelayanan kefarmasian Dinas Kesehatan Pemerintah Provinsi Riau.</p>
            <div class="sifit-section-divider"></div>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            @forelse($latestGalleries as $index => $item)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index * 0.1) }}s" style="display: flex; margin-bottom: 25px;">
                    <div class="sifit-card" style="width: 100%; display: flex; flex-direction: column; background: #ffffff; border: 1px solid var(--sifit-border); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 14px rgba(17,85,102,0.04);">
                        
                        {{-- FRAME MEDIA --}}
                        <a href="{{ route('frontend.galeri.show', $item) }}" style="height: 200px; position: relative; overflow: hidden; background: #0f172a; display: block; text-decoration: none;">
                            @if($item->type === 'photo')
                                <span style="position: absolute; top: 12px; left: 12px; background: rgba(17, 85, 102, 0.9); color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; z-index: 2;">
                                    <i class="fa fa-camera"></i> Foto
                                </span>
                                <img
                                    src="{{ $item->media_url }}"
                                    alt="{{ $item->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                                >
                            @else
                                <span style="position: absolute; top: 12px; left: 12px; background: rgba(220, 38, 38, 0.9); color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; z-index: 2;">
                                    <i class="fa fa-video-camera"></i> Video
                                </span>
                                <img
                                    src="{{ $item->media_url }}"
                                    alt="{{ $item->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                                >
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 46px; height: 46px; border-radius: 50%; background: rgba(220, 38, 38, 0.9); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 4px 14px rgba(0,0,0,0.3); pointer-events: none;">
                                    <i class="fa fa-play" style="margin-left: 2px;"></i>
                                </div>
                            @endif
                        </a>

                        {{-- KONTEN INFORMASI --}}
                        <div style="padding: 16px 18px 18px; flex: 1; display: flex; flex-direction: column;">
                            <h3 style="font-size: 15px; font-weight: 700; margin: 0 0 8px; line-height: 1.45; color: #1e293b;">
                                <a href="{{ route('frontend.galeri.show', $item) }}" style="color: inherit; text-decoration: none;">
                                    {{ $item->title }}
                                </a>
                            </h3>

                            @if($item->description)
                                <p style="color: #64748b; font-size: 12.5px; line-height: 1.55; margin: 0 0 12px;">
                                    {{ Str::limit($item->description, 100) }}
                                </p>
                            @endif

                            <div style="margin-top: auto; padding-top: 10px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; font-size: 11.5px; color: #94a3b8;">
                                <span><i class="fa fa-calendar-o"></i> {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : 'Baru' }}</span>
                                <a href="{{ route('frontend.galeri.show', $item) }}" style="color: var(--sifit-primary); font-weight: 700; text-decoration: none;">
                                    Lihat Detail <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12 text-center" style="padding: 40px 0;">
                    <div style="max-width: 450px; margin: 0 auto; padding: 30px; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <i class="fa fa-picture-o" style="font-size: 36px; color: #94a3b8; margin-bottom: 12px;"></i>
                        <h4 style="font-size: 16px; font-weight: 700; color: #1e293b;">Belum Ada Dokumentasi Galeri</h4>
                        <p style="color: #64748b; font-size: 13px; margin: 0;">Dokumentasi foto dan video kegiatan yang dipublikasikan akan tampil di sini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 20px;">
            <a href="{{ route('frontend.galeri') }}" class="thm-btn" style="padding: 12px 30px; font-size: 14px; font-weight: 700;">
                <i class="fa fa-th-large"></i> Lihat Seluruh Galeri (Foto & Video)
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
            <a href="{{ route('frontend.informasi-obat') }}" class="btn-style-two" style="padding: 10px 24px; font-size: 13px; font-weight: 700; text-decoration: none;">
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
