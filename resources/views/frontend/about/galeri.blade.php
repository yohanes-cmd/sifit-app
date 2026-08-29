@extends('frontend.layouts.app')
@section('title', 'Galeri - SIFIT')

@section('content')
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

<section class="gallery-area">
    <div class="container">
        <div class="sec-title wow fadeInUp" data-wow-delay="0.2s">
            <h1>Galeri SIFIT</h1>
            <span class="border"></span>
            <p>Dokumentasi kegiatan dan informasi visual yang tersedia pada SIFIT.</p>
        </div>

        <div class="row">
            @forelse($galeri as $item)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="single-item wow fadeInUp" data-wow-delay="0.3s">
                        <div class="img-holder">
                            @if($item->tipe_media === 'foto')
                                <img
                                    src="{{ asset('storage/' . $item->media_url) }}"
                                    alt="{{ $item->judul }}"
                                >
                            @elseif($item->tipe_media === 'video')
                                <video controls style="width: 100%;">
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
                    <div class="text-center wow fadeInUp" data-wow-delay="0.2s">
                        <h3>Belum Ada Galeri</h3>
                        <p>Dokumentasi galeri SIFIT belum tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection