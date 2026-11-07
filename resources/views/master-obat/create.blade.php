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

                    <form action="{{ route('master-obat.store') }}" method="POST" enctype="multipart/form-data">
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

                        {{-- 3. Batch Obat (Obat) / Kode Kemkes (Logistik) --}}
                        <div class="mb-4 row align-items-center" id="wrapperBatchOrKemkes">
                            <label for="kode_kemkes" class="col-sm-3 col-form-label form-label" id="labelBatchOrKemkes">
                                Batch Obat
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('kode_kemkes') is-invalid @enderror" id="kode_kemkes" name="kode_kemkes" value="{{ old('kode_kemkes') }}" placeholder="Contoh: BATCH-001, B1234">
                                <small class="text-muted" id="helpBatchOrKemkes" style="font-size: 11px;">Nomor batch untuk identifikasi kelompok produksi obat.</small>
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

                        {{-- 5. Spesifikasi Kemasan & Regulasi Farmasi --}}
                        <div class="card bg-light border-0 mb-4 p-3 rounded-3" style="background-color: #f8fafc; border: 1px dashed #cbd5e1 !important;">
                            <h6 class="fw-bold mb-3" style="color: #115566;">
                                <i class="las la-pills me-1"></i> Spesifikasi Kemasan & Regulasi Distribusi Farmasi
                            </h6>

                            <input type="hidden" name="status" value="published">
                            <input type="hidden" name="harga" value="{{ old('harga', 0) }}">

                            <div class="row mb-3">
                                <div class="col-md-6 mb-2 mb-md-0">
                                    <label for="satuan" class="form-label">Satuan Kemasan Distribusi</label>
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan', 'Pcs') }}" placeholder="Contoh: Strip, Botol, Tablet, Box, Ampul, Vial">
                                    @error('satuan') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6" id="wrapperGolongan">
                                    <label for="golongan_obat" class="form-label">Golongan Obat & Regulasi Resep <span class="text-danger">*</span></label>
                                    <select class="form-select" id="golongan_obat" name="golongan_obat" onchange="handleGolonganChange(this.value)">
                                        <option value="Obat Bebas" {{ old('golongan_obat', old('requires_prescription') ? 'Obat Keras' : 'Obat Bebas') == 'Obat Bebas' ? 'selected' : '' }}>
                                            Obat Bebas (Tanpa Resep Dokter)
                                        </option>
                                        <option value="Obat Bebas Terbatas" {{ old('golongan_obat') == 'Obat Bebas Terbatas' ? 'selected' : '' }}>
                                            Obat Bebas Terbatas (Tanpa Resep Dokter)
                                        </option>
                                        <option value="Obat Keras" {{ old('golongan_obat', old('requires_prescription') ? 'Obat Keras' : '') == 'Obat Keras' ? 'selected' : '' }}>
                                            Obat Keras (Wajib Resep Dokter)
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 p-2 px-3 rounded-2 border" id="prescriptionAlertBox" style="background-color: #f8fafc; border-color: #cbd5e1 !important;">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" class="form-check-input mt-0" id="requires_prescription" name="requires_prescription" value="1" {{ old('requires_prescription') ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-bold text-dark mb-0" for="requires_prescription" id="prescriptionLabel">
                                        <i class="las la-file-prescription fs-16 align-middle me-1"></i> Wajib menyertakan Resep Dokter yang Sah
                                    </label>
                                </div>
                                <div class="small text-muted mt-1 ps-4" id="prescriptionHelpText" style="font-size: 11px;">
                                    Centang jika obat ini memerlukan instruksi atau resep dokter sebelum penyerahan.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Foto / Gambar Obat</label>
                                <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/webp">
                                <small class="text-muted" style="font-size: 11px;">Format JPG, PNG, WEBP. Maks 2MB. Jika kosong akan menggunakan gambar default.</small>
                                @error('gambar') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label for="deskripsi" class="form-label">Deskripsi / Indikasi Farmasi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Informasi singkat indikasi, petunjuk, atau catatan obat...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <div class="text-danger small">{{ $message }}</div> @enderror
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
    function handleGolonganChange(val) {
        const check = document.getElementById('requires_prescription');
        const alertBox = document.getElementById('prescriptionAlertBox');
        const helpText = document.getElementById('prescriptionHelpText');
        const label = document.getElementById('prescriptionLabel');

        if (!check || !alertBox || !helpText) return;

        if (val === 'Obat Keras') {
            check.checked = true;
            alertBox.style.backgroundColor = '#fee2e2';
            alertBox.style.borderColor = '#fecaca';
            if (label) {
                label.className = 'form-check-label small fw-bold text-danger mb-0';
            }
            helpText.innerHTML = '<strong class="text-danger"><i class="las la-exclamation-circle"></i> Sesuai standar regulasi farmasi Dinkes: Golongan Obat Keras mutlak mewajibkan resep dokter.</strong>';
        } else {
            check.checked = false;
            alertBox.style.backgroundColor = '#f8fafc';
            alertBox.style.borderColor = '#cbd5e1';
            if (label) {
                label.className = 'form-check-label small fw-bold text-dark mb-0';
            }
            helpText.innerHTML = '<span class="text-success"><i class="las la-check-circle"></i> Obat golongan bebas dapat diserahkan langsung tanpa resep dokter.</span>';
        }
    }

    function selectJenis(jenis) {
        const inputKategori = document.getElementById('inputKategori');
        const btnObat = document.getElementById('btnPilihObat');
        const btnLogistik = document.getElementById('btnPilihLogistik');
        const wrapperGolongan = document.getElementById('wrapperGolongan');
        const alertBox = document.getElementById('prescriptionAlertBox');

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

        if (wrapperGolongan && alertBox) {
            if (jenis === 'Logistik') {
                wrapperGolongan.style.display = 'none';
                alertBox.style.display = 'none';
            } else {
                wrapperGolongan.style.display = 'block';
                alertBox.style.display = 'block';
            }
        }

        const labelBatchOrKemkes = document.getElementById('labelBatchOrKemkes');
        const inputKodeKemkes = document.getElementById('kode_kemkes');
        const helpBatchOrKemkes = document.getElementById('helpBatchOrKemkes');

        if (jenis === 'Logistik') {
            if (labelBatchOrKemkes) labelBatchOrKemkes.textContent = 'Kode Kemkes';
            if (inputKodeKemkes) inputKodeKemkes.placeholder = 'Contoh: KRD, KN, KM (Opsional untuk pelaporan Kemkes)';
            if (helpBatchOrKemkes) helpBatchOrKemkes.textContent = 'Kode standarisasi Kementerian Kesehatan / KFA untuk barang logistik & alkes.';
        } else {
            if (labelBatchOrKemkes) labelBatchOrKemkes.textContent = 'Batch Obat';
            if (inputKodeKemkes) inputKodeKemkes.placeholder = 'Contoh: BATCH-001, B1234';
            if (helpBatchOrKemkes) helpBatchOrKemkes.textContent = 'Nomor batch untuk identifikasi kelompok produksi obat.';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const golSelect = document.getElementById('golongan_obat');
        if (golSelect) {
            handleGolonganChange(golSelect.value);
        }
        const inputKategori = document.getElementById('inputKategori');
        const initialJenis = inputKategori ? (inputKategori.value || 'Obat') : 'Obat';
        selectJenis(initialJenis);
    });
</script>
@endpush