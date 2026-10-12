@extends('frontend.layouts.app')
@section('title', 'Kategori Berita - SIFIT')

@section('content')
<style>
    .sifit-cat-section {
        padding: 50px 0 70px;
        background: #f8fafc;
    }
    .sifit-cat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 25px 20px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .sifit-cat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(17, 85, 102, 0.1);
        border-color: #4db6ac;
    }
    .sifit-cat-icon {
        width: 60px;
        height: 60px;
        line-height: 60px;
        border-radius: 50%;
        background: #f0fdfa;
        color: #115566;
        font-size: 24px;
        margin-bottom: 15px;
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-folder-open" style="color: var(--sifit-accent);"></i> Kategori Warta & Informasi</h1>
                <p>Klasifikasi topik berita dan siaran resmi Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.berita') }}">Berita</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Kategori</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- DAFTAR KATEGORI BERITA --}}
<section class="sifit-cat-section">
    <div class="container">
        <div class="sec-title text-center" style="margin-bottom: 45px;">
            <h1>Kategori Informasi & Siaran Pers</h1>
            <span class="border" style="margin: 0 auto 12px;"></span>
            <p style="color: #64748b; max-width: 600px; margin: 0 auto;">
                Pilih kategori berita untuk menemukan informasi, regulasi, dan siaran pers resmi yang diterbitkan oleh SIFIT Provinsi Riau.
            </p>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            @forelse($categories as $category)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 25px;">
                    <div class="sifit-cat-card" style="width: 100%;">
                        <div class="sifit-cat-icon">
                            <i class="fa fa-folder-open-o"></i>
                        </div>

                        <h3 style="font-size: 17px; font-weight: 700; color: #115566; margin: 0 0 8px;">
                            {{ $category->name }}
                        </h3>

                        <p style="color: #64748b; font-size: 13px; margin: 0 0 16px;">
                            <strong>{{ $category->news_count ?? 0 }}</strong> artikel terpublikasi
                        </p>

                        <a href="{{ route('frontend.berita', ['category' => $category->id]) }}" class="btn-style-two" style="padding: 7px 18px; font-size: 12.5px; text-decoration: none;">
                            Lihat Berita <i class="fa fa-arrow-right" style="margin-left: 5px;"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 50px 20px; text-align: center;">
                        <i class="fa fa-folder-o" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px;"></i>
                        <h3 style="color: #115566; font-weight: 700;">Belum Ada Kategori Berita</h3>
                        <p style="color: #64748b; font-size: 13.5px;">Kategori informasi berita belum tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection