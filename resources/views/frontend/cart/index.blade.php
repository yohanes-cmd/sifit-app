@extends('frontend.layouts.app')
@section('title', 'Keranjang Permintaan Obat - SIFIT')

@section('content')
<style>
    .sifit-cart-section {
        padding: 28px 0 50px;
        background: #f8fafc;
    }
    .sifit-cart-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(17, 85, 102, 0.04);
        margin-bottom: 20px;
    }
    .sifit-cart-table {
        width: 100%;
        border-collapse: collapse;
    }
    .sifit-cart-table thead tr {
        background: #f1f5f9;
        border-bottom: 2px solid #e2e8f0;
    }
    .sifit-cart-table th {
        padding: 12px 14px;
        font-size: 12px;
        font-weight: 700;
        color: var(--sifit-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .sifit-cart-table td {
        padding: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .sifit-cart-table tbody tr:hover {
        background: #fafafa;
    }
    .sifit-summary-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 22px;
        box-shadow: 0 4px 16px rgba(17, 85, 102, 0.04);
        position: sticky;
        top: 80px;
    }
    .sifit-summary-card h4 {
        font-size: 16px;
        font-weight: 800;
        color: var(--sifit-primary);
        margin: 0 0 14px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--sifit-accent);
    }
    .sifit-btn-delete {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .sifit-btn-delete:hover {
        background: #dc2626;
        color: #ffffff;
        border-color: #dc2626;
        transform: scale(1.05);
    }
    .sifit-qty-btn {
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 6px 9px;
        cursor: pointer;
        color: #475569;
        transition: all 0.2s ease;
    }
    .sifit-qty-btn:hover {
        background: var(--sifit-primary);
        color: #ffffff;
        border-color: var(--sifit-primary);
    }
    @media (max-width: 767px) {
        .sifit-cart-card {
            padding: 14px 10px;
        }
    }
</style>

{{-- BREADCRUMB COMPACT --}}
<section class="breadcrumb-area">
    <div class="container">
        <div class="sifit-breadcrumb-wrapper">
            <div class="sifit-breadcrumb-left wow fadeInLeft" data-wow-delay="0.1s">
                <h1><i class="fa fa-shopping-basket" style="color: var(--sifit-accent);"></i> Keranjang Permintaan Obat</h1>
                <p>Daftar alokasi obat dan kelengkapan dokumen permohonan farmasi resmi</p>
            </div>
            <div class="sifit-breadcrumb-right wow fadeInRight" data-wow-delay="0.1s">
                <ul class="sifit-breadcrumb-list">
                    <li><a href="{{ route('frontend.home') }}"><i class="fa fa-home"></i> Beranda</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{ route('frontend.obat') }}">Data Obat</a></li>
                    <li><i class="fa fa-angle-right"></i></li>
                    <li class="active">Keranjang</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- KONTEN KERANJANG --}}
<section class="sifit-cart-section">
    <div class="container">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success wow fadeInDown" data-wow-delay="0.05s" style="border-radius: 6px; border-left: 4px solid #10b981; margin-bottom: 18px; padding: 10px 16px; font-size: 13px;">
                <i class="fa fa-check-circle" style="margin-right: 6px;"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger wow fadeInDown" data-wow-delay="0.05s" style="border-radius: 6px; border-left: 4px solid #ef4444; margin-bottom: 18px; padding: 10px 16px; font-size: 13px;">
                <i class="fa fa-exclamation-triangle" style="margin-right: 6px;"></i> {{ session('error') }}
            </div>
        @endif

        @if(empty($cart) || count($cart) === 0)
            {{-- EMPTY STATE --}}
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 50px 20px; box-shadow: 0 4px 16px rgba(17,85,102,0.04);">
                <div style="width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #f0fdfa; color: #115566; font-size: 28px; margin: 0 auto 16px;">
                    <i class="fa fa-shopping-basket"></i>
                </div>
                <h3 style="color: #115566; font-weight: 800; margin-bottom: 8px; font-size: 18px;">Keranjang Masih Kosong</h3>
                <p style="color: #64748b; max-width: 460px; margin: 0 auto 20px; line-height: 1.5; font-size: 13.5px;">
                    Anda belum menambahkan obat ke dalam keranjang. Silakan temukan obat yang Anda butuhkan melalui katalog farmasi resmi.
                </p>
                <a href="{{ route('frontend.obat') }}" class="thm-btn" style="padding: 9px 22px; font-size: 13px; border-radius: 6px;">
                    <i class="fa fa-search" style="margin-right: 6px;"></i> Telusuri Data Obat
                </a>
            </div>
        @else
            {{-- ALERT REGULASI OBAT RESEP --}}
            @if($hasPrescriptionItem)
                <div class="wow fadeInDown" data-wow-delay="0.05s" style="background: #fffbeb; border: 1px solid #fde68a; border-left: 4px solid #f59e0b; border-radius: 6px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; font-size: 12.5px; color: #92400e; line-height: 1.5;">
                    <i class="fa fa-exclamation-circle" style="font-size: 16px; color: #d97706; margin-top: 1px;"></i>
                    <div>
                        <strong>Pemberitahuan Regulasi Farmasi:</strong> Terdapat obat di dalam keranjang Anda yang berstatus <strong>Wajib Resep Dokter</strong>. Resep dokter yang valid wajib dilampirkan atau diverifikasi oleh tenaga farmasi resmi sebelum penyerahan obat.
                    </div>
                </div>
            @endif

            <div class="row">
                {{-- TABEL ITEM KERANJANG --}}
                <div class="col-lg-8 col-md-12 wow fadeInLeft" data-wow-delay="0.1s">
                    <div class="sifit-cart-card">
                        <div class="table-responsive">
                            <table class="sifit-cart-table">
                                <thead>
                                    <tr>
                                        <th style="min-width: 240px;">Obat Terpilih</th>
                                        <th style="min-width: 110px;">Harga Satuan</th>
                                        <th style="min-width: 120px; text-align: center;">Jumlah</th>
                                        <th style="min-width: 110px; text-align: right;">Subtotal</th>
                                        <th style="width: 50px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $item)
                                        @php
                                            $cartThumb = (!empty($item['image']) && file_exists(public_path('storage/' . $item['image'])))
                                                ? asset('storage/' . $item['image'])
                                                : asset('assets/images/product-default.svg');
                                        @endphp
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 12px;">
                                                    <div style="width: 52px; height: 52px; border-radius: 6px; background: #f8fafc; border: 1px solid #e2e8f0; overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center; padding: 4px;">
                                                        <img
                                                            src="{{ $cartThumb }}"
                                                            alt="{{ $item['name'] }}"
                                                            onerror="this.onerror=null;this.src='{{ asset('assets/images/product-default.svg') }}';"
                                                            style="max-width: 100%; max-height: 100%; object-fit: contain;"
                                                        >
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('frontend.obat.detail', $item['slug']) }}" style="font-weight: 700; color: #1e293b; font-size: 13.5px; text-decoration: none; display: block; line-height: 1.35; margin-bottom: 4px;">
                                                            {{ $item['name'] }}
                                                        </a>
                                                        <div style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                                                            <span class="sifit-badge-cat" style="font-size: 10.5px; padding: 2px 7px;">
                                                                {{ $item['category'] }}
                                                            </span>
                                                            @if(!empty($item['requires_prescription']))
                                                                <span class="sifit-badge-prescription" style="font-size: 10.5px; padding: 2px 7px;">
                                                                    <i class="fa fa-file-text-o"></i> Resep Dokter
                                                                </span>
                                                            @else
                                                                <span class="sifit-badge-otc" style="font-size: 10.5px; padding: 2px 7px;">
                                                                    <i class="fa fa-check"></i> Bebas
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span style="font-weight: 700; color: #334155; font-size: 13px;">
                                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                </span>
                                                <small style="display: block; color: #94a3b8; font-size: 11px;">/ {{ $item['unit'] ?? 'Satuan' }}</small>
                                            </td>
                                            <td style="text-align: center;">
                                                <form action="{{ route('frontend.cart.update') }}" method="POST" style="display: inline-flex; align-items: center; gap: 4px;">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] ?? 9999 }}" class="cart-qty-input" style="width: 58px; height: 34px; font-size: 13px;">
                                                    <button type="submit" title="Perbarui Jumlah" class="sifit-qty-btn">
                                                        <i class="fa fa-refresh"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="text-align: right; font-weight: 800; color: #115566; font-size: 14px;">
                                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                            </td>
                                            <td style="text-align: center;">
                                                <form id="delete-form-{{ $item['id'] }}" action="{{ route('frontend.cart.remove', $item['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="sifit-btn-delete" title="Hapus item" onclick="confirmDelete('{{ $item['id'] }}', '{{ addslashes($item['name']) }}')">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- NAVIGASI AKSI BAWAH TABEL --}}
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-top: 16px; padding-top: 14px; border-top: 1px solid #f1f5f9;">
                            <a href="{{ route('frontend.obat') }}" class="btn-style-two" style="padding: 8px 16px; font-size: 12.5px; text-decoration: none; border-radius: 4px;">
                                <i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Lanjut Telusuri Obat
                            </a>
                            <button type="button" onclick="confirmClearCart()" style="background: transparent; color: #ef4444; font-size: 12px; font-weight: 600; padding: 6px 14px; border: 1px dashed #fca5a5; border-radius: 4px; cursor: pointer; transition: all 0.2s;">
                                <i class="fa fa-trash" style="margin-right: 4px;"></i> Kosongkan Keranjang
                            </button>
                        </div>
                    </div>
                </div>

                {{-- RINGKASAN KERANJANG --}}
                <div class="col-lg-4 col-md-12 wow fadeInRight" data-wow-delay="0.15s">
                    <div class="sifit-summary-card">
                        <h4>Ringkasan Permintaan</h4>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 13.5px; color: #475569;">
                            <span>Total Item</span>
                            <strong style="color: #1e293b;">{{ $totalItems }} unit</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13.5px; color: #475569;">
                            <span>Jumlah Jenis Obat</span>
                            <strong style="color: #1e293b;">{{ count($cart) }} jenis</strong>
                        </div>
                        
                        <div style="height: 1px; background: #e2e8f0; margin: 12px 0 14px;"></div>

                        <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 16px;">
                            <span style="font-size: 14px; font-weight: 700; color: #1e293b;">Estimasi Total</span>
                            <span style="font-size: 18px; font-weight: 800; color: #115566;">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                        <div style="background: #f0fdfa; border: 1px solid #ccfbf1; border-radius: 6px; padding: 10px 12px; margin-bottom: 16px; font-size: 11.5px; color: #0f766e; line-height: 1.45;">
                            <i class="fa fa-shield" style="margin-right: 4px;"></i>
                            Data ketersediaan terhubung resmi dengan instalasi farmasi Dinkes Riau.
                        </div>

                        <a href="{{ route('frontend.contact') }}" class="thm-btn" style="width: 100%; text-align: center; display: block; padding: 11px; font-size: 13px; font-weight: 700; text-decoration: none; border-radius: 6px;">
                            <i class="fa fa-send" style="margin-right: 6px;"></i> Ajukan Permintaan / Konsultasi
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Obat Ini?',
            html: 'Item <strong>' + name + '</strong> akan dihapus dari keranjang permohonan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'sifit-swal-popup',
                confirmButton: 'sifit-swal-confirm',
                cancelButton: 'sifit-swal-cancel'
            },
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function confirmClearCart() {
        Swal.fire({
            title: 'Kosongkan Keranjang?',
            text: 'Seluruh obat di dalam keranjang permohonan akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fa fa-trash"></i> Ya, Kosongkan',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'sifit-swal-popup',
                confirmButton: 'sifit-swal-confirm',
                cancelButton: 'sifit-swal-cancel'
            },
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('frontend.cart.clear') }}";
            }
        });
    }
</script>
@endpush
