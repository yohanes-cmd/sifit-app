@extends('frontend.layouts.app')
@section('title', 'Data Obat - SIFIT')

@section('content')
<style>
    .sifit-shop-area {
        padding: 80px 0;
    }

    .sifit-sidebar {
        margin-bottom: 40px;
    }

    .sifit-sidebar .single-sidebar {
        margin-bottom: 35px;
    }

    .sifit-sidebar .sec-title {
        margin-bottom: 20px;
    }

    .sifit-info-box {
        line-height: 26px;
    }

    .sifit-result-box {
        margin-bottom: 35px;
        padding-bottom: 18px;
        border-bottom: 1px solid #eeeeee;
    }

    .sifit-product-wrapper {
        margin-bottom: 40px;
    }

    .sifit-product-card {
        height: 100%;
    }

    .sifit-product-card .img-holder {
        overflow: hidden;
    }

    .sifit-product-card .img-holder img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .sifit-product-card .title-holder {
        padding: 24px 18px 28px;
    }

    .sifit-product-card .title-holder h3 {
        margin-bottom: 10px;
    }

    .sifit-product-category {
        margin-bottom: 18px;
    }

    .sifit-product-meta {
        padding-top: 18px;
        margin-top: 15px;
        border-top: 1px solid #eeeeee;
    }

    .sifit-product-meta p {
        margin-bottom: 10px;
        line-height: 24px;
    }

    .sifit-product-meta p:last-child {
        margin-bottom: 0;
    }

    .sifit-detail-button {
        margin-top: 22px;
    }

    .sifit-empty {
        padding: 60px 20px;
    }

    .sifit-pagination {
        margin-top: 35px;
        margin-bottom: 10px;
    }

    @media (max-width: 991px) {
        .sifit-sidebar {
            margin-bottom: 50px;
        }

        .sifit-shop-area {
            padding: 60px 0;
        }
    }

    @media (max-width: 767px) {
        .sifit-shop-area {
            padding: 45px 0;
        }

        .sifit-product-card .img-holder img {
            height: auto;
        }

        .sifit-result-box {
            margin-bottom: 25px;
        }
    }
</style>

<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
                    <h1>Data Obat</h1>
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
                            <li class="active">Data Obat</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="daftar-obat" class="shop-area sifit-shop-area">
    <div class="container">
        <div class="row">

            {{-- SIDEBAR --}}
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div class="shop-sidebar sifit-sidebar wow fadeInLeft" data-wow-delay="0.2s">

                    {{-- PENCARIAN --}}
                    <div class="single-sidebar">
                        <div class="sec-title">
                            <h3>Cari Obat</h3>
                            <span class="border"></span>
                        </div>

                        <form class="search-form" action="{{ route('frontend.obat') }}" method="GET">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Masukkan nama obat..."
                            >

                            @if(request('category'))
                                <input
                                    type="hidden"
                                    name="category"
                                    value="{{ request('category') }}"
                                >
                            @endif

                            <button type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>

                    {{-- KATEGORI --}}
                    <div id="kategori-obat" class="single-sidebar">
                        <div class="sec-title">
                            <h3>Kategori Obat</h3>
                            <span class="border"></span>
                        </div>

                        <ul class="categories clearfix">
                            <li class="{{ !request('category') ? 'active' : '' }}">
                                <a href="{{ route('frontend.obat') }}">
                                    Semua Kategori
                                </a>
                            </li>

                            @foreach($categories as $category)
                                <li class="{{ request('category') == $category->id ? 'active' : '' }}">
                                    <a href="{{ route('frontend.obat', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- INFORMASI --}}
                    <div id="informasi-obat" class="single-sidebar">
                        <div class="sec-title">
                            <h3>Informasi</h3>
                            <span class="border"></span>
                        </div>

                        <div class="text sifit-info-box">
                            <p>
                                Data obat pada SIFIT membantu masyarakat memperoleh
                                informasi mengenai nama obat, kategori, harga, stok,
                                satuan, dan ketentuan resep.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DAFTAR OBAT --}}
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="shop-content">

                    {{-- HASIL --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="showing-result-shorting sifit-result-box wow fadeInUp" data-wow-delay="0.2s">
                                <div class="showing pull-left">
                                    <p>
                                        Menampilkan
                                        <strong>{{ $products->firstItem() ?? 0 }}</strong>
                                        -
                                        <strong>{{ $products->lastItem() ?? 0 }}</strong>
                                        dari
                                        <strong>{{ $products->total() }}</strong>
                                        data obat
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PRODUK --}}
                    <div class="row">
                        @forelse($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 sifit-product-wrapper">
                                <div class="single-product-item sifit-product-card wow fadeInUp" data-wow-delay="0.3s">

                                    <div class="img-holder">
                                        @if($product->image)
                                            <img
                                                src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}"
                                            >
                                        @else
                                            <img
                                                src="{{ asset('frontend/images/shop/default-product.jpg') }}"
                                                alt="{{ $product->name }}"
                                            >
                                        @endif

                                        <div class="overlay-style-one">
                                            <div class="box">
                                                <div class="content">
                                                    <a href="{{ route('frontend.obat.detail', $product->slug) }}">
                                                        <span class="flaticon-plus-symbol"></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="title-holder text-center">
                                        <div class="top">
                                            <a href="{{ route('frontend.obat.detail', $product->slug) }}">
                                                <h3>{{ $product->name }}</h3>
                                            </a>

                                            <p class="sifit-product-category">
                                                {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                                            </p>
                                        </div>

                                        <div class="product-meta sifit-product-meta">
                                            <p>
                                                <strong>Harga:</strong><br>
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </p>

                                            <p>
                                                <strong>Stok:</strong><br>
                                                {{ $product->stock }} {{ $product->unit ?? '' }}
                                            </p>

                                            <p>
                                                <strong>Resep:</strong><br>
                                                @if($product->requires_prescription)
                                                    Memerlukan Resep
                                                @else
                                                    Tidak Memerlukan Resep
                                                @endif
                                            </p>
                                        </div>

                                        <div class="sifit-detail-button">
                                            <a
                                                href="{{ route('frontend.obat.detail', $product->slug) }}"
                                                class="thm-btn bgclr-1"
                                            >
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-md-12">
                                <div class="text-center sifit-empty wow fadeInUp" data-wow-delay="0.2s">
                                    <h3>Data Obat Tidak Ditemukan</h3>

                                    @if(request('search'))
                                        <p>
                                            Tidak ada obat yang sesuai dengan pencarian
                                            "{{ request('search') }}".
                                        </p>
                                    @else
                                        <p>Belum ada data obat yang dipublikasikan.</p>
                                    @endif
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- PAGINATION --}}
                    @if($products->hasPages())
                        <div class="row sifit-pagination">
                            <div class="col-md-12">
                                <ul class="post-pagination text-center">

                                    @if($products->onFirstPage())
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-caret-left" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $products->previousPageUrl() }}">
                                                <i class="fa fa-caret-left" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    @endif

                                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        <li class="{{ $page == $products->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if($products->hasMorePages())
                                        <li>
                                            <a href="{{ $products->nextPageUrl() }}">
                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection