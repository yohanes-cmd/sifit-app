@extends('frontend.layouts.app')
@section('title', $news->title . ' - SIFIT')

@section('content')
<style>
    .sifit-news-detail {
        padding: 45px 0 55px;
    }

    .sifit-news-main {
        margin-bottom: 25px;
    }

    .sifit-news-main .img-holder {
        width: 100%;
        max-height: 430px;
        overflow: hidden;
        background: #f7f7f7;
        margin-bottom: 20px;
    }

    .sifit-news-main .img-holder img {
        width: 100%;
        max-height: 430px;
        object-fit: cover;
        display: block;
    }

    .sifit-news-main .text-holder {
        padding-top: 0 !important;
    }

    .sifit-news-main .blog-title {
        margin: 0 0 12px;
        line-height: 32px;
    }

    .sifit-news-main .meta-info {
        margin: 0 0 18px !important;
        padding: 0;
    }

    .sifit-news-main .meta-info li {
        margin-right: 18px;
        margin-bottom: 5px;
    }

    .sifit-news-content {
        margin-top: 0;
    }

    .sifit-news-content p {
        line-height: 27px;
        margin-bottom: 14px;
    }

    .sifit-news-content img {
        max-width: 100%;
        height: auto;
    }

    .sifit-pdf {
        margin-top: 18px;
    }

    .sifit-author-box {
        margin-top: 25px !important;
        padding: 18px !important;
    }

    .sifit-author-box .img-holder {
        width: 70px !important;
        height: 70px !important;
        margin-right: 15px;
    }

    .sifit-author-box .img-holder img {
        width: 70px !important;
        height: 70px !important;
        object-fit: cover;
        border-radius: 50%;
    }

    .sifit-author-box .text-holder {
        padding-top: 3px !important;
    }

    .sifit-author-box .text-holder h3 {
        margin-bottom: 5px;
    }

    .sifit-author-box .text-holder p {
        margin: 0;
        line-height: 24px;
    }

    .sifit-sidebar {
        padding-left: 15px;
    }

    .sifit-sidebar .single-sidebar {
        margin-bottom: 25px !important;
    }

    .sifit-sidebar .search-form {
        margin-bottom: 0 !important;
    }

    .sifit-sidebar .sec-title {
        margin-bottom: 15px !important;
    }

    .sifit-sidebar .sec-title h3 {
        margin-bottom: 7px;
    }

    .sifit-sidebar .popular-post {
        margin: 0;
    }

    .sifit-sidebar .popular-post li {
        padding-bottom: 15px !important;
        margin-bottom: 15px !important;
    }

    .sifit-sidebar .popular-post li:last-child {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .sifit-sidebar .popular-post .img-holder {
        width: 85px;
        height: 70px;
        overflow: hidden;
    }

    .sifit-sidebar .popular-post .img-holder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sifit-sidebar .popular-post .title-holder {
        padding-left: 12px;
    }

    .sifit-sidebar .popular-post .post-title {
        margin-bottom: 6px;
        line-height: 20px;
    }

    .sifit-sidebar .popular-post .post-date {
        margin: 0;
    }

    @media (max-width: 991px) {
        .sifit-sidebar {
            padding-left: 0;
            margin-top: 35px;
        }
    }

    @media (max-width: 767px) {
        .sifit-news-detail {
            padding: 35px 0 45px;
        }

        .sifit-news-main .img-holder,
        .sifit-news-main .img-holder img {
            max-height: 300px;
        }

        .sifit-news-main .blog-title {
            line-height: 28px;
        }

        .sifit-author-box .img-holder {
            float: none !important;
            margin-bottom: 12px;
        }
    }
</style>

{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
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
                            <li><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li><a href="{{ route('frontend.berita') }}">Berita</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active">Detail Berita</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- DETAIL BERITA --}}
<section id="blog-area" class="blog-single-area sifit-news-detail">
    <div class="container">
        <div class="row">

            {{-- ARTIKEL --}}
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="blog-post wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.2s">

                    <div class="single-blog-item sifit-news-main">

                        <div class="img-holder">
                            @if($news->image)
                                <img
                                    src="{{ asset('storage/'.$news->image) }}"
                                    alt="{{ $news->title }}"
                                >
                            @else
                                <img
                                    src="{{ asset('frontend/images/blog/blog-single.jpg') }}"
                                    alt="{{ $news->title }}"
                                >
                            @endif
                        </div>

                        <div class="text-holder">

                            <h3 class="blog-title">
                                {{ $news->title }}
                            </h3>

                            <ul class="meta-info">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        {{ $news->published_at
                                            ? \Carbon\Carbon::parse($news->published_at)->format('d M Y')
                                            : $news->created_at->format('d M Y') }}
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        {{ $news->category ? $news->category->name : 'Berita' }}
                                    </a>
                                </li>

                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        {{ $news->user ? $news->user->name : 'Admin' }}
                                    </a>
                                </li>
                            </ul>

                            <div class="text sifit-news-content">
                                {!! $news->content !!}
                            </div>

                            @if($news->pdf_file)
                                <div class="sifit-pdf">
                                    <a
                                        href="{{ asset('storage/'.$news->pdf_file) }}"
                                        target="_blank"
                                        class="thm-btn bgclr-1"
                                    >
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        Lihat PDF
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- PENULIS --}}
                    <div class="author-box sifit-author-box wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="img-holder">
                                    <img
                                        src="{{ asset('frontend/images/blog/author.jpg') }}"
                                        alt="Penulis"
                                    >
                                </div>

                                <div class="text-holder">
                                    <h3>
                                        {{ $news->user ? $news->user->name : 'Admin SIFIT' }}
                                    </h3>

                                    <p>
                                        Informasi dan berita kefarmasian melalui
                                        Sistem Informasi Farmasi Terintegrasi (SIFIT).
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="sidebar-wrapper sifit-sidebar wow fadeInRight" data-wow-duration="0.8s" data-wow-delay="0.2s">

                    {{-- PENCARIAN --}}
                    <div class="single-sidebar">
                        <form
                            class="search-form"
                            action="{{ route('frontend.berita') }}"
                            method="GET"
                        >
                            <input
                                name="search"
                                placeholder="Cari berita..."
                                type="text"
                            >

                            <button type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>

                    {{-- BERITA TERBARU --}}
                    <div class="single-sidebar">

                        <div class="sec-title">
                            <h3>Berita Terbaru</h3>
                            <span class="border"></span>
                        </div>

                        <ul class="popular-post">
                            @forelse($latestNews as $latest)
                                <li>

                                    <div class="img-holder">
                                        @if($latest->image)
                                            <img
                                                src="{{ asset('storage/'.$latest->image) }}"
                                                alt="{{ $latest->title }}"
                                            >
                                        @else
                                            <img
                                                src="{{ asset('frontend/images/sidebar/popular-post-1.jpg') }}"
                                                alt="{{ $latest->title }}"
                                            >
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
                                            <h5 class="post-title">
                                                {{ \Illuminate\Support\Str::limit($latest->title, 45) }}
                                            </h5>
                                        </a>

                                        <h6 class="post-date">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>

                                            {{ $latest->published_at
                                                ? \Carbon\Carbon::parse($latest->published_at)->format('d M Y')
                                                : $latest->created_at->format('d M Y') }}
                                        </h6>

                                    </div>

                                </li>
                            @empty
                                <li>
                                    Belum ada berita lainnya.
                                </li>
                            @endforelse
                        </ul>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection