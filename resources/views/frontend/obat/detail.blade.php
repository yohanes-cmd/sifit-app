@extends('frontend.layouts.app')
@section('title', $product->name . ' - SIFIT')

@section('content')
<style>
    .sifit-detail-area {
        padding: 32px 0 40px;
    }

    .sifit-main-image {
        width: 100%;
        height: 290px;
        overflow: hidden;
        background: #f8f8f8;
        margin-bottom: 10px;
        border: 1px solid #eeeeee;
        border-radius: 6px;
        padding: 12px;
    }

    .sifit-main-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
    }

    .sifit-detail-content {
        padding-left: 12px;
    }

    .sifit-detail-content .title {
        margin: 0 0 6px;
    }

    .sifit-detail-content .title h2 {
        margin: 0;
        line-height: 29px;
    }

    .sifit-category {
        margin-bottom: 6px;
    }

    .sifit-category p {
        margin: 0;
        line-height: 22px;
    }

    .sifit-price {
        margin-bottom: 12px;
    }

    .sifit-price h3 {
        margin: 0;
        font-size: 22px;
        line-height: 28px;
    }

    .sifit-product-info {
        margin-bottom: 12px;
        padding-top: 10px;
        border-top: 1px solid #eeeeee;
    }

    .sifit-product-info .info-item {
        margin-bottom: 5px;
    }

    .sifit-product-info .info-item:last-child {
        margin-bottom: 0;
    }

    .sifit-product-info p {
        margin: 0;
        line-height: 22px;
    }

    .sifit-detail-text {
        margin-bottom: 14px;
        padding: 10px 12px;
        background: #f8f8f8;
        border-left: 3px solid #0b98d1;
    }

    .sifit-detail-text p {
        margin: 0;
        line-height: 23px;
    }

    .sifit-back-button {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border: 1px solid #dddddd;
        border-radius: 4px;
        background: #ffffff;
        color: #555555;
        font-size: 13px;
        line-height: 18px;
        transition: all 0.3s ease;
    }

    .sifit-back-button:hover {
        color: #0b98d1;
        border-color: #0b98d1;
        background: #f8fcfe;
    }

    .sifit-back-button i {
        font-size: 14px;
    }

    .sifit-related-area {
        margin-top: 22px !important;
        padding-top: 18px !important;
        border-top: 1px solid #eeeeee;
    }

    .sifit-related-area .sec-title {
        margin: 0 0 14px !important;
        padding: 0 !important;
    }

    .sifit-related-area .sec-title h2 {
        margin: 0 0 5px !important;
        padding: 0 !important;
    }

    .sifit-related-area .sec-title .border {
        margin-bottom: 5px !important;
    }

    .sifit-related-area .sec-title p {
        margin: 5px 0 0 !important;
        line-height: 22px;
    }

    .sifit-related-row {
        display: flex;
        flex-wrap: wrap;
        margin-top: 0 !important;
        padding-top: 0 !important;
    }

    .sifit-related-wrapper {
        display: flex;
        margin-bottom: 18px;
    }

    .sifit-related-card {
        width: 100%;
        height: 100%;
        margin: 0 !important;
        border: 1px solid #eeeeee;
        border-radius: 6px;
        overflow: hidden;
        background: #ffffff;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .sifit-related-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .sifit-related-card .img-holder {
        width: 100%;
        height: 140px !important;
        overflow: hidden;
        background: #f8f8f8;
        padding: 8px;
        flex-shrink: 0;
    }

    .sifit-related-card .img-holder img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain;
        object-position: center;
        display: block;
        transition: transform 0.35s ease;
    }

    .sifit-related-card:hover .img-holder img {
        transform: scale(1.04);
    }

    .sifit-related-card .title-holder {
        padding: 10px 10px 12px !important;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .sifit-related-card .title-holder h3 {
        min-height: 42px;
        max-height: 42px;
        overflow: hidden;
        margin: 0 0 4px !important;
        line-height: 21px;
        font-size: 16px;
        display: block;
    }

    .sifit-related-card .title-holder a h3 {
        color: #222222;
        transition: color 0.3s ease;
    }

    .sifit-related-card .title-holder a:hover h3 {
        color: #0b98d1;
    }

    .sifit-related-category {
        min-height: 34px;
        max-height: 34px;
        overflow: hidden;
        margin: 0 0 4px !important;
        line-height: 17px;
        font-size: 13px;
        color: #999999;
    }

    .sifit-related-price {
        margin: auto 0 0 !important;
        line-height: 22px;
    }

    @media (max-width: 991px) {
        .sifit-detail-content {
            padding-left: 0;
        }

        .sifit-main-image {
            height: 270px;
            margin-bottom: 18px;
        }
    }

    @media (max-width: 767px) {
        .sifit-detail-area {
            padding: 28px 0 35px;
        }

        .sifit-main-image {
            height: 240px;
        }

        .sifit-related-area {
            margin-top: 20px !important;
        }

        .sifit-related-row {
            display: block;
        }

        .sifit-related-wrapper {
            display: block;
        }

        .sifit-related-card .img-holder {
            height: 190px !important;
        }

        .sifit-related-card .title-holder h3,
        .sifit-related-category {
            min-height: auto;
            max-height: none;
        }
    }
</style>

{{-- BREADCRUMB --}}
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div
                    class="breadcrumbs wow fadeInUp"
                    data-wow-duration="0.8s"
                    data-wow-delay="0.2s"
                >
                    <h1>Detail Obat</h1>
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
                                <a href="{{ route('frontend.obat') }}">Data Obat</a>
                            </li>

                            <li>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </li>

                            <li class="active">
                                {{ $product->name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- DETAIL OBAT --}}
<section class="shop-single-area sifit-detail-area">
    <div class="container">

        <div class="row">

            {{-- GAMBAR --}}
            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">

                <div
                    class="product-image sifit-main-image wow fadeInLeft"
                    data-wow-duration="0.8s"
                    data-wow-delay="0.2s"
                >
                    <img
                        src="{{ $product->image
                            ? asset('storage/'.$product->image)
                            : asset('frontend/images/shop/default-product.jpg') }}"
                        alt="{{ $product->name }}"
                    >
                </div>

            </div>

            {{-- INFORMASI --}}
            <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">

                <div
                    class="content-box sifit-detail-content wow fadeInRight"
                    data-wow-duration="0.8s"
                    data-wow-delay="0.2s"
                >

                    <div class="title">
                        <h2>{{ $product->name }}</h2>
                    </div>

                    <div class="sifit-category">
                        <p>
                            <strong>Kategori:</strong>
                            {{ $product->category
                                ? $product->category->name
                                : 'Tanpa Kategori' }}
                        </p>
                    </div>

                    <div class="price sifit-price">
                        <h3>
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h3>
                    </div>

                    <div class="product-info sifit-product-info">

                        <div class="info-item">
                            <p>
                                <strong>Stok:</strong>
                                {{ $product->stock }}
                                {{ $product->unit ?? '' }}
                            </p>
                        </div>

                        <div class="info-item">
                            <p>
                                <strong>Status:</strong>

                                @if($product->stock > 0)
                                    Tersedia
                                @else
                                    Stok Habis
                                @endif
                            </p>
                        </div>

                        <div class="info-item">
                            <p>
                                <strong>Resep Dokter:</strong>

                                @if($product->requires_prescription)
                                    Memerlukan resep dokter
                                @else
                                    Tidak memerlukan resep dokter
                                @endif
                            </p>
                        </div>

                        <div class="info-item">
                            <p>
                                <strong>Ditambahkan oleh:</strong>
                                {{ $product->user
                                    ? $product->user->name
                                    : 'Admin' }}
                            </p>
                        </div>

                    </div>

                    <div class="text sifit-detail-text">
                        <p>
                            Informasi obat ini tersedia melalui Sistem Informasi
                            Farmasi Terintegrasi (SIFIT). Pastikan penggunaan obat
                            sesuai aturan dan petunjuk tenaga kesehatan.
                        </p>
                    </div>

                    <div class="button-box">
                        <a
                            href="{{ route('frontend.obat') }}"
                            class="sifit-back-button"
                        >
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                            Kembali
                        </a>
                    </div>

                </div>

            </div>

        </div>

        {{-- OBAT TERKAIT --}}
        @if($relatedProducts->count())

            <div class="sifit-related-area">

                <div class="row">
                    <div class="col-md-12">

                        <div
                            class="sec-title wow fadeInUp"
                            data-wow-duration="0.8s"
                            data-wow-delay="0.2s"
                        >
                            <h2>Obat Terkait</h2>

                            <span class="border"></span>

                            <p>
                                Beberapa obat lain dalam kategori yang sama.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="row sifit-related-row">

                    @foreach($relatedProducts as $related)

                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 sifit-related-wrapper">

                            <div
                                class="single-product-item sifit-related-card wow fadeInUp"
                                data-wow-duration="0.8s"
                                data-wow-delay="{{ number_format(0.15 + (($loop->index % 3) * 0.12), 2) }}s"
                            >

                                <div class="img-holder">

                                    <a href="{{ route('frontend.obat.detail', $related->slug) }}">
                                        <img
                                            src="{{ $related->image
                                                ? asset('storage/'.$related->image)
                                                : asset('frontend/images/shop/default-product.jpg') }}"
                                            alt="{{ $related->name }}"
                                        >
                                    </a>

                                    <div class="overlay-style-one">
                                        <div class="box">
                                            <div class="content">

                                                <a href="{{ route('frontend.obat.detail', $related->slug) }}">
                                                    <span class="flaticon-plus-symbol"></span>
                                                </a>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="title-holder text-center">

                                    <a href="{{ route('frontend.obat.detail', $related->slug) }}">
                                        <h3>
                                            {{ $related->name }}
                                        </h3>
                                    </a>

                                    <p class="sifit-related-category">
                                        {{ $related->category
                                            ? $related->category->name
                                            : 'Tanpa Kategori' }}
                                    </p>

                                    <p class="sifit-related-price">
                                        <strong>
                                            Rp {{ number_format($related->price, 0, ',', '.') }}
                                        </strong>
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        @endif

    </div>
</section>
@endsection