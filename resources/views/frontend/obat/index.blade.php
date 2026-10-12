@extends('frontend.layouts.app')
@section('title', 'Direktori & Data Obat - SIFIT')

@section('content')
<style>
    .sifit-shop-area {
        padding: 28px 0 50px;
        background: #f8fafc;
    }
    .sifit-sidebar-unified {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.04);
        position: sticky;
        top: 80px;
    }
    .sifit-sidebar-unified .sidebar-title {
        font-size: 15px;
        font-weight: 800;
        color: var(--sifit-primary);
        margin: 0 0 12px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .sifit-sidebar-search-box {
        position: relative;
        margin-bottom: 16px;
    }
    .sifit-sidebar-search-box input {
        width: 100%;
        height: 38px;
        padding: 6px 40px 6px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 13px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .sifit-sidebar-search-box input:focus {
        border-color: var(--sifit-accent);
        box-shadow: 0 0 0 3px rgba(77, 182, 172, 0.15);
        outline: none;
    }
    .sifit-sidebar-search-box button {
        position: absolute;
        right: 4px;
        top: 4px;
        bottom: 4px;
        width: 32px;
        background: var(--sifit-primary);
        color: #ffffff;
        border: none;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .sifit-sidebar-search-box button:hover {
        background: var(--sifit-primary-dark);
    }
    .sifit-sidebar-divider {
        height: 1px;
        background: #f1f5f9;
        margin: 16px 0;
    }
    .sifit-cat-list {
        list-style: none;
        padding: 0;
        margin: 0 0 16px 0;
    }
    .sifit-cat-list li {
        margin-bottom: 5px;
    }
    .sifit-cat-list li a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 7px 12px;
        border-radius: 6px;
        color: #475569;
        font-size: 13px;
        text-decoration: none;
        background: #f8fafc;
        border: 1px solid #eef2f6;
        transition: all 0.2s ease;
    }
    .sifit-cat-list li.active a,
    .sifit-cat-list li a:hover {
        background: var(--sifit-primary);
        color: #ffffff;
        border-color: var(--sifit-primary);
        padding-left: 14px;
        font-weight: 600;
    }
    .sifit-product-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 14px rgba(17, 85, 102, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .sifit-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 24px rgba(17, 85, 102, 0.12);
        border-color: rgba(77, 182, 172, 0.7);
    }
    @media (max-width: 767px) {
        .sifit-sidebar-unified {
            margin-bottom: 24px;
            position: static;
        }
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-medkit" style="color: var(--sifit-accent);"></i> Data & Katalog Obat Resmi</h1>
                <p>Direktori ketersediaan, kategori, dan informasi farmasi Dinas Kesehatan Provinsi Riau</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Data Obat</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KATALOG OBAT --}}
<section class="sifit-shop-area">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success wow fadeInDown" data-wow-delay="0.05s" style="border-radius: 6px; border-left: 4px solid #10b981; margin-bottom: 20px; padding: 10px 16px; font-size: 13px;">
                <i class="fa fa-check-circle" style="margin-right: 6px;"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger wow fadeInDown" data-wow-delay="0.05s" style="border-radius: 6px; border-left: 4px solid #ef4444; margin-bottom: 20px; padding: 10px 16px; font-size: 13px;">
                <i class="fa fa-exclamation-triangle" style="margin-right: 6px;"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row">

            {{-- SIDEBAR FILTER TUNGGAL (Unified) --}}
            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div class="sifit-sidebar-unified wow fadeInLeft" data-wow-delay="0.1s">
                    <h4 class="sidebar-title">
                        <i class="fa fa-search" style="color: var(--sifit-accent);"></i> Cari Data Obat
                    </h4>
                    <form action="{{ route('frontend.obat') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="sifit-sidebar-search-box">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Nama obat / indikasi..."
                            >
                            <button type="submit" title="Cari">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="sifit-sidebar-divider"></div>

                    <h4 class="sidebar-title">
                        <i class="fa fa-folder-open" style="color: var(--sifit-accent);"></i> Kategori Obat
                    </h4>
                    <ul class="sifit-cat-list">
                        <li class="{{ !request('category') ? 'active' : '' }}">
                            <a href="{{ route('frontend.obat', request('search') ? ['search' => request('search')] : []) }}">
                                <span>Semua Kategori</span>
                                <i class="fa fa-chevron-right" style="font-size: 10px;"></i>
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li class="{{ request('category') == $category->id ? 'active' : '' }}">
                                <a href="{{ route('frontend.obat', array_merge(['category' => $category->id], request('search') ? ['search' => request('search')] : [])) }}">
                                    <span>{{ $category->name }}</span>
                                    <i class="fa fa-chevron-right" style="font-size: 10px;"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="sifit-sidebar-divider"></div>

                    <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 6px; padding: 10px 12px; font-size: 11.5px; color: #0f766e; line-height: 1.45;">
                        <i class="fa fa-info-circle" style="margin-right: 4px;"></i>
                        <strong>Layanan Resmi:</strong> Data obat bersumber dari instalasi farmasi resmi Dinkes Riau.
                    </div>
                </div>
            </div>

            {{-- DAFTAR PRODUK / OBAT --}}
            <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12">
                {{-- STATUS BAR FILTER --}}
                <div class="wow fadeInDown" data-wow-delay="0.05s" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 16px; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                    <p style="margin: 0; color: #64748b; font-size: 13px;">
                        Menampilkan <strong>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</strong> dari <strong>{{ $products->total() }}</strong> obat terdaftar
                    </p>
                    @if(request('search') || request('category'))
                        <a href="{{ route('frontend.obat') }}" style="color: #ef4444; font-size: 12px; font-weight: 700; text-decoration: none;">
                            <i class="fa fa-times"></i> Reset Filter
                        </a>
                    @endif
                </div>

                <div class="row" style="display: flex; flex-wrap: wrap;">
                    @forelse($products as $index => $product)
                        @php
                            $prodThumb = ($product->image && file_exists(public_path('storage/'.$product->image))) ? asset('storage/'.$product->image) : asset('assets/images/product-default.svg');
                            $delay = 0.05 + (($index % 6) * 0.06);
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="{{ $delay }}s" style="display: flex; margin-bottom: 20px;">
                            <div class="sifit-product-card" style="width: 100%;">
                                {{-- GAMBAR OBAT --}}
                                <div style="height: 160px; background: #f8fafc; padding: 12px; display: flex; align-items: center; justify-content: center; position: relative; border-bottom: 1px solid #f1f5f9;">
                                    <img
                                        src="{{ $prodThumb }}"
                                        alt="{{ $product->name }}"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/product-default.svg') }}';"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain; transition: transform 0.3s ease;"
                                    >
                                    <div style="position: absolute; top: 8px; left: 8px;">
                                        @if($product->requires_prescription)
                                            <span class="sifit-badge-prescription" title="Wajib resep dokter">
                                                <i class="fa fa-file-text-o"></i> Resep
                                            </span>
                                        @else
                                            <span class="sifit-badge-otc" title="Obat bebas">
                                                <i class="fa fa-check"></i> Bebas
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- DETAIL KARTU --}}
                                <div style="padding: 14px; flex: 1; display: flex; flex-direction: column;">
                                    <span class="sifit-badge-cat" style="align-self: flex-start; margin-bottom: 6px; font-size: 11px;">
                                        {{ $product->category ? $product->category->name : 'Umum' }}
                                    </span>

                                    <h3 style="font-size: 14.5px; font-weight: 700; margin: 0 0 6px; line-height: 1.35; min-height: 38px;">
                                        <a href="{{ route('frontend.obat.detail', $product->slug) }}" style="color: #1e293b; text-decoration: none; transition: color 0.2s ease;">
                                            {{ $product->name }}
                                        </a>
                                    </h3>

                                    <div style="margin-top: auto; padding-top: 8px; border-top: 1px solid #f1f5f9;">
                                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                                            <div>
                                                <span style="font-size: 15px; font-weight: 800; color: #115566;">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                                <small style="color: #94a3b8; font-size: 10.5px;">/ {{ $product->unit ?? 'Satuan' }}</small>
                                            </div>
                                            <span style="font-size: 11px; color: #64748b;">
                                                Stok: <strong>{{ $product->stock ?? 0 }}</strong>
                                            </span>
                                        </div>

                                        <div style="display: flex; gap: 6px;">
                                            <a href="{{ route('frontend.obat.detail', $product->slug) }}" class="btn-style-two" style="flex: 1; text-align: center; padding: 6px 8px; font-size: 11.5px; text-decoration: none;">
                                                Detail
                                            </a>
                                            <form action="{{ route('frontend.cart.add', $product->id) }}" method="POST" style="flex: 1.3;">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn-add-cart" style="width: 100%; justify-content: center; font-size: 11.5px; padding: 6px 8px;">
                                                    <i class="fa fa-shopping-basket"></i> + Keranjang
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="text-center" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 40px 20px;">
                                <i class="fa fa-medkit" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                <h3 style="color: #115566; font-weight: 800; margin-bottom: 6px; font-size: 16px;">Data Obat Tidak Ditemukan</h3>
                                <p style="color: #64748b; font-size: 13px;">
                                    @if(request('search'))
                                        Tidak ditemukan obat dengan kata kunci "{{ request('search') }}".
                                    @else
                                        Belum ada data obat yang terpublikasi pada kategori ini.
                                    @endif
                                </p>
                                <a href="{{ route('frontend.obat') }}" class="thm-btn" style="margin-top: 8px; padding: 6px 18px; font-size: 12.5px;">
                                    Kembali ke Semua Obat
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINATION --}}
                @if($products->hasPages())
                    <div style="margin-top: 20px; text-align: center;">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection