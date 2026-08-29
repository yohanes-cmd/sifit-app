@extends('frontend.layouts.app')
@section('title', 'Berita - SIFIT')

@section('content')
{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs">
                    <h1>Berita</h1>
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
                            <li class="active">Berita</li>
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

{{-- BLOG AREA --}}
<section id="blog-area" class="blog-default-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="blog-post">
                    <div class="row">
                        @forelse($news as $item)
                            <div class="col-md-6">
                                <div class="single-blog-item wow fadeInUp" data-wow-delay="0s" data-wow-duration="1s" data-wow-offset="0">
                                    <div class="img-holder">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                                        @else
                                            <img src="{{ asset('frontend/images/blog/blog-default-1.jpg') }}" alt="{{ $item->title }}">
                                        @endif
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
                                    <div class="text-holder">
                                        <a href="{{ route('frontend.berita.detail', $item->slug) }}">
                                            <h3 class="blog-title">{{ $item->title }}</h3>
                                        </a>
                                        <div class="text">
                                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 120) }}</p>
                                        </div>
                                        <ul class="meta-info">
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    {{ $item->published_at ? \Carbon\Carbon::parse($item->published_at)->format('d M Y') : $item->created_at->format('d M Y') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-folder-open" aria-hidden="true"></i>
                                                    {{ $item->category ? $item->category->name : 'Berita' }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h3>Belum Ada Berita</h3>
                                    <p>Berita terbaru SIFIT akan ditampilkan di halaman ini.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- PAGINATION --}}
                    @if($news->hasPages())
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="post-pagination text-center">
                                    @if($news->onFirstPage())
                                        <li><a href="javascript:void(0)"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>
                                    @else
                                        <li><a href="{{ $news->previousPageUrl() }}"><i class="fa fa-caret-left" aria-hidden="true"></i></a></li>
                                    @endif

                                    @foreach($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                                        <li class="{{ $page == $news->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if($news->hasMorePages())
                                        <li><a href="{{ $news->nextPageUrl() }}"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>
                                    @else
                                        <li><a href="javascript:void(0)"><i class="fa fa-caret-right" aria-hidden="true"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4 col-md-6 col-sm-7 col-xs-12">
                <div class="sidebar-wrapper">
                    <div class="single-sidebar wow fadeInUp">
                        <form class="search-form" action="{{ route('frontend.berita') }}" method="GET">
                            <input name="search" value="{{ request('search') }}" placeholder="Cari berita..." type="text">
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
                            @foreach($news->take(3) as $latest)
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
                            @endforeach
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