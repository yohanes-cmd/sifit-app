@extends('frontend.layouts.app')
@section('title', $product->name . ' - SIFIT')

@section('content')
<section class="breadcrumb-area" style="background-image: url('/frontend/images/resources/breadcrumb-bg.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumbs wow fadeInUp" data-wow-delay="0.2s">
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
                            <li><a href="{{ route('frontend.home') }}">Beranda</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li><a href="{{ route('frontend.obat') }}">Data Obat</a></li>
                            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
                            <li class="active">{{ $product->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shop-single-area" style="padding: 80px 0;">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
                <div class="product-image wow fadeInLeft" data-wow-delay="0.3s" style="margin-bottom: 30px;">
                    @if($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="img-responsive"
                            style="width: 100%;"
                        >
                    @else
                        <img
                            src="{{ asset('frontend/images/shop/default-product.jpg') }}"
                            alt="{{ $product->name }}"
                            class="img-responsive"
                            style="width: 100%;"
                        >
                    @endif
                </div>
            </div>

            <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                <div class="content-box wow fadeInRight" data-wow-delay="0.3s" style="padding-left: 25px;">
                    <div class="title" style="margin-bottom: 20px;">
                        <h2>{{ $product->name }}</h2>
                    </div>

                    <div class="category" style="margin-bottom: 15px;">
                        <p>
                            <strong>Kategori:</strong>
                            {{ $product->category ? $product->category->name : 'Tanpa Kategori' }}
                        </p>
                    </div>

                    <div class="price" style="margin-bottom: 30px;">
                        <h3>Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                    </div>

                    <div class="product-info" style="margin-bottom: 30px;">
                        <div style="margin-bottom: 15px;">
                            <p>
                                <strong>Stok:</strong>
                                {{ $product->stock }} {{ $product->unit ?? '' }}
                            </p>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <p>
                                <strong>Status:</strong>
                                Tersedia
                            </p>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <p>
                                <strong>Resep Dokter:</strong>
                                @if($product->requires_prescription)
                                    Memerlukan resep dokter
                                @else
                                    Tidak memerlukan resep dokter
                                @endif
                            </p>
                        </div>

                        <div>
                            <p>
                                <strong>Ditambahkan oleh:</strong>
                                {{ $product->user ? $product->user->name : 'Admin' }}
                            </p>
                        </div>
                    </div>

                    <div class="text" style="margin-bottom: 35px;">
                        <p style="line-height: 28px;">
                            Informasi obat ini tersedia melalui Sistem Informasi Farmasi Terintegrasi (SIFIT).
                            Pastikan penggunaan obat sesuai aturan dan petunjuk tenaga kesehatan.
                        </p>
                    </div>

                    <div class="button-box">
                        <a href="{{ route('frontend.obat') }}" class="thm-btn bgclr-1">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Kembali ke Data Obat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if($relatedProducts->count())
            <div class="row" style="margin-top: 90px;">
                <div class="col-md-12">
                    <div class="sec-title wow fadeInUp" data-wow-delay="0.2s" style="margin-bottom: 40px;">
                        <h2>Obat Terkait</h2>
                        <span class="border"></span>
                        <p>Beberapa obat lain dalam kategori yang sama.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($relatedProducts as $related)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="single-product-item wow fadeInUp" data-wow-delay="0.3s" style="margin-bottom: 40px;">
                            <div class="img-holder">
                                @if($related->image)
                                    <img
                                        src="{{ asset('storage/' . $related->image) }}"
                                        alt="{{ $related->name }}"
                                    >
                                @else
                                    <img
                                        src="{{ asset('frontend/images/shop/default-product.jpg') }}"
                                        alt="{{ $related->name }}"
                                    >
                                @endif

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

                            <div class="title-holder text-center" style="padding-top: 20px;">
                                <a href="{{ route('frontend.obat.detail', $related->slug) }}">
                                    <h3>{{ $related->name }}</h3>
                                </a>

                                <p style="margin-top: 10px;">
                                    {{ $related->category ? $related->category->name : 'Tanpa Kategori' }}
                                </p>

                                <p style="margin-top: 8px;">
                                    <strong>
                                        Rp {{ number_format($related->price, 0, ',', '.') }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection