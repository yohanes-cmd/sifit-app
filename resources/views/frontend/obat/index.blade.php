@extends('frontend.layouts.app')
@section('title', 'Data Obat - SIFIT')

@section('content')
<style>
    .sifit-shop-area {
        padding: 45px 0 60px;
    }

    .sifit-sidebar {
        margin: 0 !important;
        padding: 0 !important;
    }

    .sifit-sidebar .single-sidebar {
        margin: 0 0 22px !important;
        padding: 0 !important;
    }

    .sifit-sidebar .sec-title {
        margin: 0 0 12px !important;
        padding: 0 !important;
    }

    .sifit-sidebar .sec-title h3 {
        margin: 0 0 7px !important;
        padding: 0 !important;
    }

    .sifit-sidebar .search-form {
        margin: 0 !important;
        padding: 0 !important;
    }

    .sifit-sidebar .search-form input {
        margin: 0 !important;
    }

    .sifit-sidebar #kategori-obat {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .sifit-sidebar #kategori-obat .sec-title {
        margin-bottom: 12px !important;
    }

    .sifit-sidebar .categories {
        margin: 0 !important;
        padding: 12px 35px !important;
    }

    .sifit-sidebar .categories li {
        margin: 0 !important;
        padding: 9px 0 !important;
    }

    .sifit-sidebar .categories li a {
        margin: 0 !important;
        padding: 0 !important;
    }

    .sifit-info-box {
        line-height: 25px;
    }

    .sifit-result-box {
        margin-bottom: 22px;
        padding-bottom: 12px;
        border-bottom: 1px solid #eeeeee;
    }

    .sifit-result-box p {
        margin: 0;
    }

    .sifit-product-row {
        display: flex;
        flex-wrap: wrap;
    }

    .sifit-product-wrapper {
        display: flex;
        margin-bottom: 30px;
    }

    .sifit-product-card {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.35s ease, box-shadow 0.35s ease;
    }

    .sifit-product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    }

    .sifit-product-card .img-holder {
        width: 100%;
        height: 220px !important;
        overflow: hidden;
        background: #f7f7f7;
        flex-shrink: 0;
    }

    .sifit-product-card .img-holder img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .sifit-product-card:hover .img-holder img {
        transform: scale(1.06);
    }

    .sifit-product-card .title-holder {
        padding: 20px 18px 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .sifit-product-card .top {
        min-height: 105px;
    }

    .sifit-product-card .title-holder h3 {
        min-height: 52px;
        margin: 0 0 8px;
        line-height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sifit-product-category {
        min-height: 42px;
        margin: 0;
        line-height: 21px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sifit-product-meta {
        padding-top: 15px;
        margin-top: 0;
        border-top: 1px solid #eeeeee;
    }

    .sifit-product-meta p {
        min-height: 58px;
        margin: 0 0 8px;
        line-height: 22px;
    }

    .sifit-product-meta p:last-child {
        margin-bottom: 0;
    }

    .sifit-detail-button {
        margin-top: auto;
        padding-top: 18px;
    }

    .sifit-detail-button .thm-btn {
        width: 100%;
        display: block;
        text-align: center;
        padding: 12px 15px;
        transition: transform 0.3s ease;
    }

    .sifit-detail-button .thm-btn:hover {
        transform: translateY(-2px);
    }

    .sifit-empty {
        padding: 45px 20px;
    }

    .sifit-pagination {
        margin-top: 20px;
        margin-bottom: 10px;
    }

    @media (max-width: 991px) {
        .sifit-shop-area {
            padding: 40px 0 55px;
        }

        .sifit-sidebar {
            margin-bottom: 35px !important;
        }
    }

    @media (max-width: 767px) {
        .sifit-shop-area {
            padding: 35px 0 45px;
        }

        .sifit-result-box {
            margin-bottom: 20px;
        }

        .sifit-product-row {
            display: block;
        }

        .sifit-product-wrapper {
            display: block;
        }

        .sifit-product-card .img-holder {
            height: 240px !important;
        }

        .sifit-product-card .top,
        .sifit-product-card .title-holder h3,
        .sifit-product-category {
            min-height: auto;
        }
    }
</style>

<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div
                    class="breadcrumbs wow fadeInUp"
                    data-wow-duration="0.8s"
                    data-wow-delay="0.2s"
                >
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

            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div
                    class="shop-sidebar sifit-sidebar wow fadeInLeft"
                    data-wow-duration="0.8s"
                    data-wow-delay="0.2s"
                >

                    <div class="single-sidebar">
                        <div class="sec-title">
                            <h3>Cari Obat</h3>
                            <span class="border"></span>
                        </div>

                        <form
                            class="search-form"
                            action="{{ route('frontend.obat') }}"
                            method="GET"
                        >
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

            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="shop-content">

                    <div class="row">
                        <div class="col-md-12">
                            <div
                                class="showing-result-shorting sifit-result-box wow fadeInDown"
                                data-wow-duration="0.8s"
                                data-wow-delay="0.2s"
                            >
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

                    <div class="row sifit-product-row">
                        @forelse($products as $product)

                            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 sifit-product-wrapper">

                                <div
                                    class="single-product-item sifit-product-card wow fadeInUp"
                                    data-wow-duration="0.8s"
                                    data-wow-delay="{{ number_format(0.15 + (($loop->index % 3) * 0.15), 2) }}s"
                                >

                                    <div class="img-holder">

                                        <img
                                            src="{{ $product->image ? asset('storage/'.$product->image) : asset('frontend/images/shop/default-product.jpg') }}"
                                            alt="{{ $product->name }}"
                                        >

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
                                <div
                                    class="text-center sifit-empty wow fadeInUp"
                                    data-wow-duration="0.8s"
                                    data-wow-delay="0.2s"
                                >
                                    <h3>Data Obat Tidak Ditemukan</h3>

                                    @if(request('search'))
                                        <p>
                                            Tidak ada obat yang sesuai dengan pencarian
                                            "{{ request('search') }}".
                                        </p>
                                    @else
                                        <p>
                                            Belum ada data obat yang dipublikasikan.
                                        </p>
                                    @endif
                                </div>
                            </div>

                        @endforelse
                    </div>

                    @if($products->hasPages())
                        <div
                            class="row sifit-pagination wow fadeInUp"
                            data-wow-duration="0.8s"
                            data-wow-delay="0.2s"
                        >
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
                                            <a href="{{ $url }}">
                                                {{ $page }}
                                            </a>
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