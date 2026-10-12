@extends('frontend.layouts.app')
@section('title', $product->name . ' - Detail Obat SIFIT')

@section('content')
<style>
    .sifit-detail-section {
        padding: 22px 0 36px;
        background: #f8fafc;
    }
    .sifit-detail-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 22px 24px 20px;
        box-shadow: 0 4px 16px rgba(17, 85, 102, 0.04);
    }
    .sifit-img-frame {
        width: 100%;
        height: 280px;
        background: #fafafa;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        position: relative;
    }
    .sifit-img-frame img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }
    .sifit-img-frame:hover img {
        transform: scale(1.04);
    }
    .sifit-spec-table {
        width: 100%;
        margin-top: 12px;
        border-collapse: collapse;
    }
    .sifit-spec-table td {
        padding: 7px 10px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }
    .sifit-spec-table td:first-child {
        width: 38%;
        color: #64748b;
        font-weight: 600;
    }
    .sifit-spec-table td:last-child {
        color: #1e293b;
        font-weight: 600;
    }
    .sifit-card-rel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .sifit-card-rel:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(17, 85, 102, 0.08);
        border-color: var(--sifit-accent);
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-file-text-o" style="color: var(--sifit-accent);"></i> {{ $product->name }}</h1>
                <p>Informasi spesifikasi, indikasi, dan ketersediaan farmasi resmi</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.obat') }}">Data Obat</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ Str::limit($product->name, 25) }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KONTEN DETAIL OBAT --}}
<section class="sifit-detail-section">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success wow fadeInDown" data-wow-delay="0.05s" style="border-radius: 6px; border-left: 4px solid #10b981; margin-bottom: 20px; padding: 10px 16px; font-size: 13px;">
                <i class="fa fa-check-circle" style="margin-right: 6px;"></i> {{ session('success') }}
                <a href="{{ route('frontend.cart.index') }}" style="color: #065f46; font-weight: 700; margin-left: 10px; text-decoration: underline;">
                    Lihat Keranjang <i class="fa fa-arrow-right"></i>
                </a>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger wow fadeInDown" data-wow-delay="0.05s" style="border-radius: 6px; border-left: 4px solid #ef4444; margin-bottom: 20px; padding: 10px 16px; font-size: 13px;">
                <i class="fa fa-exclamation-triangle" style="margin-right: 6px;"></i> {{ session('error') }}
            </div>
        @endif

        <div class="sifit-detail-card wow fadeInUp" data-wow-delay="0.1s">
            <div class="row">

                {{-- FOTO OBAT --}}
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <div class="sifit-img-frame">
                        @php
                            $pDetailThumb = ($product->image && file_exists(public_path('storage/'.$product->image))) ? asset('storage/'.$product->image) : asset('assets/images/product-default.svg');
                        @endphp
                        <img
                            src="{{ $pDetailThumb }}"
                            alt="{{ $product->name }}"
                            onerror="this.onerror=null;this.src='{{ asset('assets/images/product-default.svg') }}';"
                        >
                        <div style="position: absolute; top: 10px; left: 10px;">
                            @if($product->requires_prescription)
                                <span class="sifit-badge-prescription">
                                    <i class="fa fa-file-text-o"></i> Resep Dokter
                                </span>
                            @else
                                <span class="sifit-badge-otc">
                                    <i class="fa fa-check"></i> Bebas
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- DESKRIPSI & AKSI KERANJANG --}}
                <div class="col-lg-7 col-md-7 col-sm-12">
                    <div style="padding-left: 6px;">
                        <span class="sifit-badge-cat" style="margin-bottom: 8px; display: inline-block;">
                            {{ $product->category ? $product->category->name : 'Kategori Umum' }}
                        </span>

                        <h2 style="font-size: 22px; font-weight: 800; color: #115566; margin: 0 0 8px; line-height: 1.3;">
                            {{ $product->name }}
                        </h2>

                        <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 14px;">
                            <span style="font-size: 22px; font-weight: 800; color: #115566;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span style="color: #64748b; font-size: 12.5px;">/ {{ $product->unit ?? 'Satuan' }}</span>
                        </div>

                        {{-- PERINGATAN RESEP DOKTER --}}
                        @if($product->requires_prescription)
                            <div class="sifit-alert-prescription" style="margin-bottom: 14px; padding: 10px 14px; font-size: 12px;">
                                <i class="fa fa-exclamation-circle" style="font-size: 16px;"></i>
                                <div>
                                    <strong>Ketentuan Resep:</strong> Obat keras / terbatas yang memerlukan instruksi dan resep dokter yang sah sebelum penyerahan.
                                </div>
                            </div>
                        @endif

                        {{-- TABEL SPESIFIKASI SINGKAT --}}
                        <table class="sifit-spec-table">
                            <tbody>
                                <tr>
                                    <td>Status Ketersediaan</td>
                                    <td>
                                        @if(($product->stock ?? 0) > 0)
                                            <span style="color: #059669;"><i class="fa fa-check-circle"></i> Tersedia ({{ $product->stock }} {{ $product->unit }})</span>
                                        @else
                                            <span style="color: #dc2626;"><i class="fa fa-times-circle"></i> Stok Habis</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Golongan / Regulasi</td>
                                    <td>{{ $product->requires_prescription ? 'Obat Keras (Wajib Resep)' : 'Obat Bebas / Bebas Terbatas' }}</td>
                                </tr>
                                <tr>
                                    <td>Satuan Kemasan</td>
                                    <td>{{ $product->unit ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Instansi Penyedia</td>
                                    <td>Instalasi Farmasi Dinas Kesehatan Provinsi Riau</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- FORM TAMBAH KE KERANJANG --}}
                        <form action="{{ route('frontend.cart.add', $product->id) }}" method="POST" style="margin-top: 18px; padding-top: 16px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            @csrf
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <label style="margin: 0; font-size: 12.5px; font-weight: 600; color: #475569;">Qty:</label>
                                <input
                                    type="number"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    max="{{ $product->stock ?? 9999 }}"
                                    class="cart-qty-input"
                                    style="width: 65px; height: 38px; font-size: 14px;"
                                >
                            </div>

                            <button type="submit" class="thm-btn" style="height: 38px; padding: 0 18px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;" {{ ($product->stock ?? 0) <= 0 ? 'disabled' : '' }}>
                                <i class="fa fa-shopping-basket"></i> Tambah ke Keranjang
                            </button>

                            <a href="{{ route('frontend.obat') }}" class="btn-style-two" style="height: 38px; padding: 0 14px; font-size: 12.5px; display: inline-flex; align-items: center; text-decoration: none;">
                                <i class="fa fa-arrow-left" style="margin-right: 4px;"></i> Kembali
                            </a>
                        </form>
                    </div>
                </div>

            </div>

            {{-- DESKRIPSI & INFORMASI TAMBAHAN --}}
            <div style="margin-top: 18px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
                <h3 style="font-size: 15.5px; font-weight: 700; color: #115566; margin-bottom: 6px;">
                    Deskripsi & Keterangan Farmasi
                </h3>
                <div style="color: #475569; line-height: 1.65; font-size: 13.5px;">
                    @if($product->description)
                        {!! nl2br(e($product->description)) !!}
                    @else
                        <p style="margin: 0;">Informasi detail mengenai indikasi, kontraindikasi, dosis, dan petunjuk pemakaian obat ini dapat dikonsultasikan langsung dengan dokter atau apoteker penanggung jawab pada fasilitas pelayanan kesehatan terkait.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- OBAT TERKAIT --}}
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div style="margin-top: 22px;" class="wow fadeInUp" data-wow-delay="0.15s">
                <div style="margin-bottom: 14px;">
                    <h3 style="font-size: 16px; font-weight: 800; color: #115566; margin: 0 0 6px 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-cubes" style="color: var(--sifit-accent); font-size: 15px;"></i> Obat Terkait Lainnya
                    </h3>
                    <div style="width: 36px; height: 3px; background: var(--sifit-accent); border-radius: 2px;"></div>
                </div>

                <div class="row" style="display: flex; flex-wrap: wrap;">
                    @foreach($relatedProducts as $relIndex => $related)
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12" style="display: flex; margin-bottom: 16px;">
                            <div class="sifit-card-rel" style="width: 100%; display: flex; flex-direction: column;">
                                <div style="height: 130px; background: #f8fafc; padding: 8px; display: flex; align-items: center; justify-content: center; position: relative;">
                                    @php
                                        $relThumb = ($related->image && file_exists(public_path('storage/'.$related->image))) ? asset('storage/'.$related->image) : asset('assets/images/product-default.svg');
                                    @endphp
                                    <img
                                        src="{{ $relThumb }}"
                                        alt="{{ $related->name }}"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/product-default.svg') }}';"
                                    >
                                </div>
                                <div style="padding: 12px; flex: 1; display: flex; flex-direction: column;">
                                    <h4 style="font-size: 13px; font-weight: 700; margin: 0 0 4px;">
                                        <a href="{{ route('frontend.obat.detail', $related->slug) }}" style="color: #1e293b; text-decoration: none;">
                                            {{ $related->name }}
                                        </a>
                                    </h4>
                                    <span style="font-size: 13px; font-weight: 800; color: #115566; margin-top: auto;">
                                        Rp {{ number_format($related->price, 0, ',', '.') }}
                                    </span>
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