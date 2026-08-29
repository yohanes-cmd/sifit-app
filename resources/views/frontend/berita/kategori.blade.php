@extends('frontend.layouts.app')
@section('title', 'Kategori Berita - SIFIT')

@section('content')
{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1>Kategori Berita</h1>
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
                                <a href="{{ route('frontend.berita') }}">Berita</a>
                            </li>
                            <li>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </li>
                            <li class="active">Kategori Berita</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI BERITA --}}
<section class="medical-departments-area">
    <div class="container">
        <div class="sec-title">
            <h1>Kategori Berita</h1>
            <span class="border"></span>
            <p>Pilih kategori untuk melihat berita dan informasi yang tersedia di SIFIT.</p>
        </div>

        <div class="row">
            @forelse($categories as $category)
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="single-item text-center">
                        <div class="iocn-holder">
                            <span class="flaticon-medical"></span>
                        </div>

                        <div class="text-holder">
                            <h3>{{ $category->nama_kategori }}</h3>

                            <p>
                                {{ $category->berita_count ?? 0 }}
                                berita tersedia
                            </p>
                        </div>

                        <a class="readmore"
                            href="{{ route('frontend.berita', ['kategori' => $category->id_kategori]) }}">
                            Lihat Berita
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="text-center">
                        <h3>Belum Ada Kategori Berita</h3>
                        <p>Kategori berita belum tersedia di SIFIT.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection