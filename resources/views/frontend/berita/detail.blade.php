@extends('frontend.layouts.app')
@section('title', $news->title . ' - SIFIT')

@section('content')
{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1>Detail Berita</h1>
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
                            <li><a href="/">Beranda</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li><a href="{{ route('frontend.berita') }}">Berita</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active">Detail Berita</li>
                        </ul>
                    </div>
                    <div class="right pull-right">
                        <a href="#"><span><i class="fa fa-share-alt" aria-hidden="true"></i> Bagikan</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BLOG SINGLE --}}
<section id="blog-area" class="blog-single-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="blog-post">
                    <div class="single-blog-item">
                        <div class="img-holder">
                            @if($news->image)
                                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}">
                            @else
                                <img src="{{ asset('frontend/images/blog/blog-single.jpg') }}" alt="{{ $news->title }}">
                            @endif
                        </div>

                        <div class="text-holder">
                            <h3 class="blog-title">{{ $news->title }}</h3>

                            <ul class="meta-info">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('d M Y') : $news->created_at->format('d M Y') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        {{ $news->category ? $news->category->name : 'Berita' }}
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ $news->user ? $news->user->name : 'Admin' }}
                                    </a>
                                </li>
                            </ul>

                            <div class="text">
                                {!! $news->content !!}
                            </div>

                            @if($news->pdf_file)
                                <div style="margin-top: 30px;">
                                    <a href="{{ asset('storage/' . $news->pdf_file) }}" target="_blank" class="thm-btn bgclr-1">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        Lihat PDF
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- SHARE --}}
                    <div class="tag-social-share-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="social-share clearfix">
                                    <h5>Bagikan <i class="fa fa-share-alt" aria-hidden="true"></i></h5>
                                    <ul class="social-share-links">
                                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- AUTHOR --}}
                    <div class="author-box">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="img-holder">
                                    <img src="{{ asset('frontend/images/blog/author.jpg') }}" alt="Penulis">
                                </div>
                                <div class="text-holder">
                                    <h3>{{ $news->user ? $news->user->name : 'Admin SIFIT' }}</h3>
                                    <p>Informasi dan berita kefarmasian melalui Sistem Informasi Farmasi Terintegrasi (SIFIT).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4 col-md-6 col-sm-7 col-xs-12">
                <div class="sidebar-wrapper">
                    <div class="single-sidebar wow fadeInUp">
                        <form class="search-form" action="{{ route('frontend.berita') }}" method="GET">
                            <input name="search" placeholder="Cari berita..." type="text">
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                        </form>
                    </div>

                    <div class="single-sidebar wow fadeInUp">
                        <div class="sec-title">
                            <h3>Kategori</h3>
                        </div>
                        <ul class="categories clearfix">
                            <li><a href="#">Informasi Obat</a></li>
                            <li><a href="#">Edukasi Farmasi</a></li>
                            <li><a href="#">Tips Kesehatan</a></li>
                            <li><a href="#">Berita SIFIT</a></li>
                            <li><a href="#">Pengumuman</a></li>
                        </ul>
                    </div>

                    <div class="single-sidebar wow fadeInUp">
                        <div class="sec-title">
                            <h3>Berita Terbaru</h3>
                        </div>
                        <ul class="popular-post">
                            @forelse($latestNews as $latest)
                                <li>
                                    <div class="img-holder">
                                        @if($latest->image)
                                            <img src="{{ asset('storage/' . $latest->image) }}" alt="{{ $latest->title }}">
                                        @else
                                            <img src="{{ asset('frontend/images/sidebar/popular-post-1.jpg') }}" alt="{{ $latest->title }}">
                                        @endif
                                        <div class="overlay-style-one">
                                            <div class="box">
                                                <div class="content">
                                                    <a href="{{ route('frontend.berita.detail', $latest->slug) }}">
                                                        <span class="flaticon-plus-symbol"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="title-holder">
                                        <a href="{{ route('frontend.berita.detail', $latest->slug) }}">
                                            <h5 class="post-title">{{ \Illuminate\Support\Str::limit($latest->title, 45) }}</h5>
                                        </a>
                                        <h6 class="post-date">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                            {{ $latest->published_at ? \Carbon\Carbon::parse($latest->published_at)->format('d M Y') : $latest->created_at->format('d M Y') }}
                                        </h6>
                                    </div>
                                </li>
                            @empty
                                <li>Belum ada berita lainnya.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="single-sidebar">
                        <div class="sec-title">
                            <h3>Tag</h3>
                        </div>
                        <ul class="popular-tag">
                            <li><a href="#">Obat</a></li>
                            <li><a href="#">Farmasi</a></li>
                            <li><a href="#">Kesehatan</a></li>
                            <li><a href="#">Edukasi</a></li>
                            <li><a href="#">SIFIT</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- END SIDEBAR --}}
        </div>
    </div>
</section>
@endsection