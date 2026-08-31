@extends('frontend.layouts.app')
@section('title', 'Galeri - SIFIT')

@section('content')
<style>
    .sifit-gallery-area {
        padding: 80px 0 90px;
    }

    .sifit-gallery-area .sec-title {
        margin-bottom: 50px;
    }

    .sifit-gallery-area .sec-title p {
        margin-top: 12px;
        line-height: 26px;
    }

    .sifit-gallery-area .gallery-item {
        margin-bottom: 35px;
    }

    .sifit-gallery-area .gallery-item .img-holder {
        overflow: hidden;
        margin-bottom: 20px;
    }

    .sifit-gallery-area .gallery-item .img-holder img,
    .sifit-gallery-area .gallery-item .img-holder video {
        width: 100%;
        display: block;
    }

    .sifit-gallery-area .gallery-item .text-holder {
        padding: 0 10px 10px;
    }

    .sifit-gallery-area .gallery-item .text-holder h3 {
        margin-bottom: 10px;
    }

    .sifit-gallery-area .gallery-item .text-holder p {
        line-height: 25px;
        margin: 0;
    }

    .sifit-gallery-empty {
        padding: 70px 20px 80px;
        min-height: 240px;
    }

    .sifit-gallery-empty .icon-holder {
        margin-bottom: 20px;
    }

    .sifit-gallery-empty .icon-holder span {
        font-size: 50px;
    }

    .sifit-gallery-empty h3 {
        margin-bottom: 12px;
    }

    .sifit-gallery-empty p {
        margin: 0;
        line-height: 26px;
    }

    @media (max-width: 991px) {
        .sifit-gallery-area {
            padding: 65px 0 75px;
        }
    }

    @media (max-width: 767px) {
        .sifit-gallery-area {
            padding: 50px 0 60px;
        }

        .sifit-gallery-area .sec-title {
            margin-bottom: 35px;
        }

        .sifit-gallery-empty {
            padding: 50px 15px 60px;
            min-height: 200px;
        }
    }
</style>

{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>Galeri</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="breadcrumb-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="left pull-left">
                        <ul>
                            <li>
                                <a href="{{ route('frontend.home') }}">Beranda</a>
                            </li>
                            <li>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </li>
                            <li>
                                <a href="{{ route('frontend.about') }}">Tentang Kami</a>
                            </li>
                            <li>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </li>
                            <li class="active">Galeri</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- GALERI --}}
<section class="gallery-area sifit-gallery-area">
    <div class="container">
        <div class="sec-title mar0auto text-center wow fadeInUp" data-wow-delay="0.2s">
            <h1>Galeri SIFIT</h1>
            <span class="border"></span>
            <p>
                Dokumentasi kegiatan dan informasi visual
                yang tersedia pada SIFIT.
            </p>
        </div>

        <div class="row">
            @forelse($galeri as $item)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="single-item gallery-item wow fadeInUp" data-wow-delay="0.3s">
                        <div class="img-holder">
                            @if($item->tipe_media === 'foto')
                                <img
                                    src="{{ asset('storage/' . $item->media_url) }}"
                                    alt="{{ $item->judul }}"
                                >
                            @elseif($item->tipe_media === 'video')
                                <video controls>
                                    <source src="{{ asset('storage/' . $item->media_url) }}">
                                    Browser Anda tidak mendukung video.
                                </video>
                            @endif
                        </div>

                        <div class="text-holder text-center">
                            <h3>{{ $item->judul }}</h3>

                            @if($item->deskripsi)
                                <p>{{ $item->deskripsi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="sifit-gallery-empty text-center wow fadeInUp" data-wow-delay="0.3s">
                        <div class="icon-holder">
                            <span class="flaticon-agenda"></span>
                        </div>

                        <h3>Belum Ada Galeri</h3>

                        <p>
                            Dokumentasi galeri SIFIT belum tersedia.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection