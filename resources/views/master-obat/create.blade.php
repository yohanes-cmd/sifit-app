@extends('layouts.app')

@section('title', 'Tambah Master Obat/Logistik - SIFIT')

@push('css')
<style>
    .form-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control {
        border-color: #cbd5e1;
        font-size: 13.5px;
        padding: 9px 13px;
        border-radius: 6px;
    }
    .form-control:focus {
        border-color: #115566;
        box-shadow: 0 0 0 3px rgba(77, 182, 172, 0.25);
    }
    .btn-toggle-jenis {
        padding: 7px 22px;
        font-size: 13px;
        font-weight: 700;
        border-radius: 6px;
        cursor: pointer;
        border: 1.5px solid #cbd5e1;
        background: #ffffff;
        color: #475569;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-toggle-jenis.active-obat {
        background: #115566;
        border-color: #115566;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(17, 85, 102, 0.3);
    }
    .btn-toggle-jenis.active-logistik {
        background: #0284c7;
        border-color: #0284c7;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(2, 132, 199, 0.3);
    }
    .btn-sifit-submit {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
        color: #ffffff;
        border: none;
        padding: 9px 24px;
        border-radius: 6px;
        font-size: 13.5px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 3px 10px rgba(2, 132, 199, 0.3);
    }
    .btn-sifit-submit:hover {
        background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Page Header --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Master Obat/Logistik</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('master-obat.index') }}">Master Obat/Logistik</a></li>
                            <li class="breadcrumb-item active">Tambah Baru</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('master-obat.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="las la-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    
                    <div class="mb-4 pb-2 border-bottom">
                        <h5 class="fw-bold mb-1" style="color: #115566;">Master Obat/Logistik</h5>
                        <p class="text-muted small mb-0">Masukan informasi yang kurang dibawah. Bagian bertanda <span class="text-danger">*</span> TIDAK BOLEH kosong.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center mb-1">
                                <i class="las la-exclamation-triangle fs-18 me-2"></i>
                                <strong>Mohon periksa form isian:</strong>
                            </div>
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('master-obat.store') }}" method="POST">
                        @csrf

                        {{-- Hidden Input Kategori --}}
                        <input type="hidden" name="kategori" id="inputKategori" value="{{ old('kategori', $isLogistikOnly ? 'Logistik' : 'Obat') }}">

                        {{-- 1. Kode Obat/Logistik (Auto generated / sequential) --}}
                        <div class="mb-3 row align-items-center">
                            <label for="kode_obat" class="col-sm-3 col-form-label form-label">
                                Kode Obat/Logistik <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('kode_obat') is-invalid @enderror" id="kode_obat" name="kode_obat" value="{{ old('kode_obat', $nextCode) }}" required placeholder="Contoh: 07197">
                                <small class="text-muted" style="font-size: 11px;">Terisi secara otomatis berurutan.</small>
                            </div>
                        </div>

                        {{-- 2. Nama Obat/Logistik (Manual) --}}
                        <div class="mb-3 row align-items-center">
                            <label for="nama_obat" class="col-sm-3 col-form-label form-label">
                                Nama Obat/Logistik <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('nama_obat') is-invalid @enderror" id="nama_obat" name="nama_obat" value="{{ old('nama_obat') }}" required placeholder="Masukkan nama obat atau logistik" autofocus>
                            </div>
                        </div>

                        {{-- 3. Kode Kemkes (Manual) --}}
                        <div class="mb-4 row align-items-center">
                            <label for="kode_kemkes" class="col-sm-3 col-form-label form-label">
                                Kode Kemkes
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('kode_kemkes') is-invalid @enderror" id="kode_kemkes" name="kode_kemkes" value="{{ old('kode_kemkes') }}" placeholder="Contoh: KRD, KN, KM (Opsional untuk pelaporan)">
                            </div>
                        </div>

                        {{-- 4. Tombol Pilihan Jenis: OBAT / LOGISTIK --}}
                        <div class="mb-4 row align-items-center">
                            <label class="col-sm-3 col-form-label form-label">
                                Jenis Barang <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <div class="d-inline-flex gap-2" role="group">
                                    @if(!$isLogistikOnly)
                                        <button type="button" class="btn-toggle-jenis {{ old('kategori', $isLogistikOnly ? 'Logistik' : 'Obat') == 'Obat' ? 'active-obat' : '' }}" id="btnPilihObat" onclick="selectJenis('Obat')">
                                            <i class="las la-capsules me-1"></i> OBAT
                                        </button>
                                    @endif

                                    @if(!$isFarmasiOnly)
                                        <button type="button" class="btn-toggle-jenis {{ old('kategori', $isLogistikOnly ? 'Logistik' : 'Obat') == 'Logistik' ? 'active-logistik' : '' }}" id="btnPilihLogistik" onclick="selectJenis('Logistik')">
                                            <i class="las la-boxes me-1"></i> LOGISTIK
                                        </button>
                                    @endif
                                </div>
                                <div class="text-muted mt-1" style="font-size: 11px;">
                                    Pilih jenis untuk memisahkan antara obat farmasi dan logistik / alat kesehatan.
                                </div>
                            </div>
                        </div>

                        {{-- 5. Tombol Submit: Tambah Obat/Logistik --}}
                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn-sifit-submit">
                                    <i class="las la-plus-circle fs-16"></i> Tambah Obat/Logistik
                                </button>
                                <a href="{{ route('master-obat.index') }}" class="btn btn-outline-secondary ms-2" style="padding: 8px 18px; font-size: 13px; border-radius: 6px;">
                                    Batal
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function selectJenis(jenis) {
        const inputKategori = document.getElementById('inputKategori');
        const btnObat = document.getElementById('btnPilihObat');
        const btnLogistik = document.getElementById('btnPilihLogistik');

        if (inputKategori) {
            inputKategori.value = jenis;
        }

        if (btnObat) {
            if (jenis === 'Obat') {
                btnObat.classList.add('active-obat');
            } else {
                btnObat.classList.remove('active-obat');
            }
        }

        if (btnLogistik) {
            if (jenis === 'Logistik') {
                btnLogistik.classList.add('active-logistik');
            } else {
                btnLogistik.classList.remove('active-logistik');
            }
        }
    }
</script>
@endpush