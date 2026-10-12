@extends('frontend.layouts.app')
@section('title', 'Galeri Dokumentasi Kegiatan - SIFIT')

@section('content')
<style>
    .sifit-gallery-section {
        padding: 50px 0 70px;
        background: #f8fafc;
    }
    .sifit-gallery-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .sifit-gallery-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(17, 85, 102, 0.1);
        border-color: #4db6ac;
    }
    .sifit-media-frame {
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: #0f172a;
        position: relative;
    }
    .sifit-media-frame img,
    .sifit-media-frame video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-picture-o" style="color: var(--sifit-accent);"></i> Galeri Dokumentasi Kegiatan</h1>
                <p>Dokumentasi program pelayanan kefarmasian dan sosialisasi Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.about') }}">Tentang Kami</a></li>
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
        <div class="sec-title text-center" style="margin-bottom: 45px;">
            <h1>Dokumentasi Pelayanan & Kegiatan Farmasi</h1>
            <span class="border" style="margin: 0 auto 12px;"></span>
            <p style="color: #64748b; max-width: 650px; margin: 0 auto; line-height: 1.6;">
                Dokumentasi visual kegiatan kefarmasian, monitoring obat, dan pelayanan publik yang diselenggarakan oleh Pemerintah Provinsi Riau melalui SIFIT.
            </p>
        </div>

        <div class="row" style="display: flex; flex-wrap: wrap;">
            @forelse($galeri as $item)
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 30px;">
                    <div class="sifit-gallery-card" style="width: 100%;">
                        {{-- FRAME MEDIA --}}
                        <div class="sifit-media-frame">
                            @if($item->tipe_media === 'foto' || str_contains($item->tipe_media ?? '', 'foto'))
                                <img
                                    src="{{ asset('storage/' . $item->media_url) }}"
                                    alt="{{ $item->judul }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                >
                                <span style="position: absolute; top: 12px; left: 12px; background: rgba(17, 85, 102, 0.85); color: #ffffff; padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-camera"></i> Foto
                                </span>
                            @elseif($item->tipe_media === 'video' || str_contains($item->tipe_media ?? '', 'video'))
                                <video controls style="width: 100%; height: 100%;">
                                    <source src="{{ asset('storage/' . $item->media_url) }}">
                                    Browser Anda tidak mendukung video.
                                </video>
                                <span style="position: absolute; top: 12px; left: 12px; background: rgba(220, 38, 38, 0.85); color: #ffffff; padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fa fa-video-camera"></i> Video
                                </span>
                            @else
                                <img
                                    src="{{ asset('storage/' . $item->media_url) }}"
                                    alt="{{ $item->judul }}"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/news-default.svg') }}';"
                                >
                            @endif
                        </div>

                        {{-- TEKS KETERANGAN --}}
                        <div style="padding: 18px; flex: 1; display: flex; flex-direction: column;">
                            <h3 style="font-size: 16px; font-weight: 700; color: #115566; margin: 0 0 8px; line-height: 1.4;">
                                {{ $item->judul }}
                            </h3>
                            @if($item->deskripsi)
                                <p style="color: #64748b; font-size: 13px; line-height: 1.6; margin: 0;">
                                    {{ $item->deskripsi }}
                                </p>
                            @endif
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
                        <p style="color: #64748b; font-size: 13.5px; max-width: 450px; margin: 0 auto;">
                            Dokumentasi foto dan video kegiatan instalasi farmasi SIFIT sedang dalam proses pembaruan oleh tim pengelola data.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- PAGINASI --}}
        @if(method_exists($galeri, 'hasPages') && $galeri->hasPages())
            <div style="margin-top: 30px; text-align: center;">
                {{ $galeri->links() }}
            </div>
        @endif
    </div>
</section>
@endsection