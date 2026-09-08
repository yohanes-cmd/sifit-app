@extends('frontend.layouts.app')
@section('title', 'Data Obat - SIFIT')

@section('content')
<style>
    .sifit-shop-area {
        padding: 35px 0 45px;
    }

    .sifit-sidebar {
        margin: 0 !important;
        padding: 0 !important;
    }

    .sifit-sidebar .single-sidebar {
        margin: 0 0 18px !important;
        padding: 0 !important;
    }

    .sifit-sidebar .sec-title {
        margin: 0 0 10px !important;
        padding: 0 !important;
    }

    .sifit-sidebar .sec-title h3 {
        margin: 0 0 6px !important;
    }

    .sifit-sidebar .search-form {
        margin: 0 !important;
        padding: 0 !important;
    }

    .sifit-sidebar .categories {
        margin: 0 !important;
        padding: 10px 28px !important;
    }

    .sifit-sidebar .categories li {
        margin: 0 !important;
        padding: 7px 0 !important;
    }

    .sifit-info-box {
        line-height: 23px;
    }

    .sifit-result-box {
        margin-bottom: 18px;
        padding-bottom: 10px;
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
        margin-bottom: 22px;
    }

    .sifit-product-card {
        width: 100%;
        height: 100%;
        background: #ffffff;
        border: 1px solid #eeeeee;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
    }

    .sifit-product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.10);
        border-color: transparent;
    }

    .sifit-product-card .img-holder {
        width: 100%;
        height: 165px;
        background: #fafafa;
        overflow: hidden;
        padding: 10px;
        flex-shrink: 0;
    }

    .sifit-product-card .img-holder img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        transition: transform 0.4s ease;
    }

    .sifit-product-card:hover .img-holder img {
        transform: scale(1.05);
    }

    .sifit-product-content {
        padding: 14px 14px 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .sifit-product-name {
        margin: 0 0 5px;
        min-height: 44px;
        max-height: 44px;
        overflow: hidden;
        font-size: 17px;
        line-height: 22px;
        display: block;
    }

    .sifit-product-name a {
        color: #222222;
        display: block;
        transition: color 0.3s ease;
    }

    .sifit-product-name a:hover,
    .sifit-product-name a:focus {
        color: #0b98d1;
    }

    .sifit-product-category {
        margin: 0 0 10px;
        min-height: 38px;
        max-height: 38px;
        overflow: hidden;
        font-size: 13px;
        line-height: 19px;
        color: #999999;
    }

    .sifit-product-price {
        margin: 0 0 10px;
        min-height: 32px;
        font-size: 18px;
        font-weight: 700;
        line-height: 24px;
        color: #222222;
        display: flex;
        align-items: center;
    }

    .sifit-product-info {
        border-top: 1px solid #eeeeee;
        padding-top: 10px;
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .sifit-product-info span {
        width: 50%;
        min-height: 44px;
        font-size: 12px;
        line-height: 18px;
        color: #777777;
    }

    .sifit-product-info span:last-child {
        text-align: right;
    }

    .sifit-product-info strong {
        display: block;
        color: #444444;
        font-size: 12px;
        margin-bottom: 2px;
    }

    .sifit-empty {
        padding: 35px 20px;
    }

    .sifit-pagination {
        margin-top: 15px;
        margin-bottom: 5px;
    }

    @media (max-width: 991px) {
        .sifit-sidebar {
            margin-bottom: 30px !important;
        }
    }

    @media (max-width: 767px) {
        .sifit-shop-area {
            padding: 30px 0 40px;
        }

        .sifit-product-row {
            display: block;
        }

        .sifit-product-wrapper {
            display: block;
        }

        .sifit-product-card .img-holder {
            height: 210px;
        }

        .sifit-product-name,
        .sifit-product-category,
        .sifit-product-price,
        .sifit-product-info span {
            min-height: auto;
            max-height: none;
        }
    }
</style>

<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
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
                            <li><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
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
                <div class="shop-sidebar sifit-sidebar wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.2s">

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

                    <div id="kategori-obat" class="single-sidebar">
                        <div class="sec-title">
                            <h3>Kategori Obat</h3>
                            <span class="border"></span>
                        </div>

                        <ul class="categories clearfix">
                            <li class="{{ !request('category') ? 'active' : '' }}">
                                <a href="{{ route('frontend.obat') }}">Semua Kategori</a>
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
                                Data obat pada SIFIT membantu masyarakat memperoleh informasi mengenai nama obat, kategori, harga, stok, satuan, dan ketentuan resep.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="shop-content">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="showing-result-shorting sifit-result-box wow fadeInDown" data-wow-duration="0.8s" data-wow-delay="0.2s">
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

                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 sifit-product-wrapper">

                                <div
                                    class="sifit-product-card wow fadeInUp"
                                    data-wow-duration="0.8s"
                                    data-wow-delay="{{ number_format(0.10 + (($loop->index % 4) * 0.12), 2) }}s"
                                    data-wow-offset="40"
                                >

                                    <a href="{{ route('frontend.obat.detail', $product->slug) }}">
                                        <div class="img-holder">
                                            <img
                                                src="{{ $product->image
                                                    ? asset('storage/'.$product->image)
                                                    : asset('frontend/images/shop/default-product.jpg') }}"
                                                alt="{{ $product->name }}"
                                            >
                                        </div>
                                    </a>

                                    <div class="sifit-product-content">

                                        <h3 class="sifit-product-name">
                                            <a href="{{ route('frontend.obat.detail', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h3>

                                        <p class="sifit-product-category">
                                            {{ $product->category
                                                ? $product->category->name
                                                : 'Tanpa Kategori' }}
                                        </p>

                                        <p class="sifit-product-price">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </p>

                                        <div class="sifit-product-info">
                                            <span>
                                                <strong>Stok</strong>
                                                {{ $product->stock }} {{ $product->unit ?? '' }}
                                            </span>

                                            <span>
                                                <strong>Resep</strong>
                                                @if($product->requires_prescription)
                                                    Perlu
                                                @else
                                                    Tidak
                                                @endif
                                            </span>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="col-md-12">
                                <div class="text-center sifit-empty wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
                                    <h3>Data Obat Tidak Ditemukan</h3>

                                    @if(request('search'))
                                        <p>
                                            Tidak ada obat yang sesuai dengan pencarian "{{ request('search') }}".
                                        </p>
                                    @else
                                        <p>Belum ada data obat yang dipublikasikan.</p>
                                    @endif
                                </div>
                            </div>

                        @endforelse
                    </div>

                    @if($products->hasPages())
                        <div class="row sifit-pagination wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof WOW !== 'undefined') {
            new WOW({
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 40,
                mobile: true,
                live: true
            }).init();
        }
    });
</script>
@endsection