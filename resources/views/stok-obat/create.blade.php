@extends('layouts.app')

@section('title', 'Tambahkan Obat/Logistik - SIFIT')

@push('css')
<style>
    .form-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control, .form-select {
        border-color: #cbd5e1;
        font-size: 13.5px;
        padding: 9px 13px;
        border-radius: 8px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #115566;
        box-shadow: 0 0 0 3px rgba(77, 182, 172, 0.25);
    }
    .btn-sifit-submit {
        background: linear-gradient(135deg, #115566 0%, #0d4452 50%, #4db6ac 100%);
        color: #ffffff;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 3px 10px rgba(17, 85, 102, 0.25);
    }
    .btn-sifit-submit:hover {
        background: linear-gradient(135deg, #0d4452 0%, #09313b 50%, #3b9b91 100%);
        color: #ffffff;
    }
    .image-preview-box {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        border: 2px dashed #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f8fafc;
    }
    .image-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
                        <h4 class="page-title">Tambahkan Obat/Logistik</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('stok-obat.index') }}">Daftar Obat/Logistik</a></li>
                            <li class="breadcrumb-item active">Tambah Baru</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('stok-obat.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="las la-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    
                    <div class="mb-4 pb-2 border-bottom">
                        <h5 class="fw-bold mb-1" style="color: #115566;">Tambahkan Obat/Logistik</h5>
                        <p class="text-muted small mb-0">Masukkan Informasi Obat/Logistik dengan lengkap dan benar.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                            <div class="d-flex align-items-center mb-1">
                                <i class="las la-exclamation-triangle fs-18 me-2"></i>
                                <strong>Mohon periksa kembali form isian:</strong>
                            </div>
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('stok-obat.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">

                            {{-- 1. Master Obat/Logistik Selection (Dropdown auto-fill) --}}
                            <div class="col-md-6">
                                <label for="master_obat_id" class="form-label">Master Obat/Logistik <span class="text-danger">*</span></label>
                                <select class="form-select @error('master_obat_id') is-invalid @enderror" id="master_obat_id" name="master_obat_id" required>
                                    <option value="">-- Pilih Master Obat/Logistik --</option>
                                    @foreach($masterObats as $master)
                                        <option value="{{ $master->id }}" 
                                                data-kode="{{ $master->kode_obat }}"
                                                data-nama="{{ $master->nama_obat }}"
                                                data-kategori="{{ $master->kategori }}"
                                                data-satuan="{{ $master->satuan }}"
                                                data-harga="{{ $master->harga }}"
                                                {{ old('master_obat_id') == $master->id ? 'selected' : '' }}>
                                            {{ $master->kode_obat }} - {{ $master->nama_obat }} ({{ $master->satuan }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted" style="font-size: 11px;">Pilih master obat untuk mengisi otomatis nama, satuan & harga dasar.</small>
                            </div>

                            {{-- 2. Lokasi Gudang --}}
                            <div class="col-md-6">
                                <label for="gudang_id" class="form-label">Lokasi Gudang Penyimpanan <span class="text-danger">*</span></label>
                                <select class="form-select @error('gudang_id') is-invalid @enderror" id="gudang_id" name="gudang_id" required>
                                    <option value="">-- Pilih Gudang --</option>
                                    @foreach($gudangs as $g)
                                        <option value="{{ $g->id }}" {{ old('gudang_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama_gudang }} ({{ $g->lokasi ?? 'Pekanbaru' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 3. Kode Obat/Logistik (Manual) --}}
                            <div class="col-md-6">
                                <label for="kode_obat_logistik" class="form-label">Kode Obat/Logistik</label>
                                <input type="text" class="form-control @error('kode_obat_logistik') is-invalid @enderror" id="kode_obat_logistik" name="kode_obat_logistik" value="{{ old('kode_obat_logistik') }}" placeholder="Contoh: 24620251504/202607198)0R02K045023">
                            </div>

                            {{-- 4. Nama Obat/Logistik (Manual) --}}
                            <div class="col-md-6">
                                <label for="nama_obat_logistik" class="form-label">Nama Obat/Logistik</label>
                                <input type="text" class="form-control @error('nama_obat_logistik') is-invalid @enderror" id="nama_obat_logistik" name="nama_obat_logistik" value="{{ old('nama_obat_logistik') }}" placeholder="Masukkan nama obat/logistik">
                            </div>

                            {{-- 5. Kategori (Dropdown List Sesuai Kerangka) --}}
                            <div class="col-md-4">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                                    <option value="">Pilih Kategori</option>
                                    @php
                                        $kategoriOptions = [
                                            'APBN',
                                            'Bantuan Pihak Ketiga',
                                            'Global Fund',
                                            'GAVI',
                                            'Realokasi',
                                            'APBD Logistik',
                                            'APBN Logistik',
                                            'Global Fund Logistik',
                                            '(LOGISTIK) UEA',
                                            'USAID',
                                        ];
                                    @endphp
                                    @foreach($kategoriOptions as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori', 'APBN') == $kat ? 'selected' : '' }}>
                                            {{ $kat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 6. Sub Kategori (Dropdown List Sesuai Kerangka) --}}
                            <div class="col-md-4">
                                <label for="sub_kategori" class="form-label">Sub Kategori</label>
                                <select class="form-select @error('sub_kategori') is-invalid @enderror" id="sub_kategori" name="sub_kategori">
                                    <option value="">Pilih Sub Kategori</option>
                                    @php
                                        $subKategoriOptions = [
                                            '[LOGISTIK] UEA | UEA TB Logistik',
                                            '[APBD] Buffer',
                                            '[APBD] Program Cacingan',
                                            '[APBD] Program Diare',
                                            '[APBD] Program Filariasis',
                                            '[APBD] Program Flu Burung',
                                            '[APBD] Program Gizi',
                                            '[APBD] Program Hepatitis',
                                            '[APBD] Program HIV',
                                            '[APBD] Program Imunisasi',
                                            '[APBD] Program ISPA',
                                            '[APBD] Program Kusta',
                                            '[APBD] Program Malaria',
                                            '[APBD] Program DBD',
                                            '[APBD] Program TB',
                                            '[APBN] Program Vaksin Anti Rabies (VAR)',
                                            '[APBN] Program Vaksin Imunisasi',
                                            '[Global Fund] Program HIV/AIDS',
                                            '[Global Fund] Program Malaria',
                                            '[Global Fund] Program TB Paru',
                                        ];
                                    @endphp
                                    @foreach($subKategoriOptions as $sub)
                                        <option value="{{ $sub }}" {{ old('sub_kategori') == $sub ? 'selected' : '' }}>
                                            {{ $sub }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- 7. Tahun Penerimaan --}}
                            <div class="col-md-4">
                                <label for="tahun_penerimaan" class="form-label">Tahun Penerimaan</label>
                                <input type="text" class="form-control @error('tahun_penerimaan') is-invalid @enderror" id="tahun_penerimaan" name="tahun_penerimaan" value="{{ old('tahun_penerimaan', date('Y')) }}" placeholder="Contoh: 2025 / 2026">
                            </div>

                            {{-- 8. Date Expired --}}
                            <div class="col-md-4">
                                <label for="exp_date" class="form-label">Date Expired</label>
                                <input type="date" class="form-control @error('exp_date') is-invalid @enderror" id="exp_date" name="exp_date" value="{{ old('exp_date') }}">
                            </div>

                            {{-- 9. Date Expired Kode (Manual) --}}
                            <div class="col-md-4">
                                <label for="date_expired_kode" class="form-label">Date Expired Kode</label>
                                <input type="text" class="form-control @error('date_expired_kode') is-invalid @enderror" id="date_expired_kode" name="date_expired_kode" value="{{ old('date_expired_kode') }}" placeholder="Kode Expired">
                            </div>

                            {{-- 10. Nomor Batch (Manual) --}}
                            <div class="col-md-4">
                                <label for="no_batch" class="form-label">Nomor Batch <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_batch') is-invalid @enderror" id="no_batch" name="no_batch" value="{{ old('no_batch') }}" required placeholder="Contoh: BATCH-2026-001">
                            </div>

                            {{-- 11. Satuan Obat/Logistik (Manual) --}}
                            <div class="col-md-4">
                                <label for="satuan" class="form-label">Satuan Obat/Logistik</label>
                                <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="satuan" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: Vial 300 IU/1 ml, KOTAK / 100 TABLET, Ampul, Pcs">
                            </div>

                            {{-- 12. Kemasan (Manual) --}}
                            <div class="col-md-4">
                                <label for="kemasan" class="form-label">Kemasan</label>
                                <input type="text" class="form-control @error('kemasan') is-invalid @enderror" id="kemasan" name="kemasan" value="{{ old('kemasan') }}" placeholder="Contoh: Box @ 10 strip">
                            </div>

                            {{-- 13. Harga Satuan (Manual) --}}
                            <div class="col-md-4">
                                <label for="harga_satuan" class="form-label">Harga Obat/Logistik (Rp)</label>
                                <input type="number" step="0.01" class="form-control @error('harga_satuan') is-invalid @enderror" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan', 0) }}" placeholder="0.00">
                            </div>

                            {{-- 14. Jumlah Barang (Stok Fisik Awal) --}}
                            <div class="col-md-4">
                                <label for="jumlah" class="form-label">Jumlah Barang <span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', 0) }}" required placeholder="Jumlah stok">
                            </div>

                            {{-- 15. Nama Pabrikan (Manual) --}}
                            <div class="col-md-4">
                                <label for="nama_pabrikan" class="form-label">Nama Pabrikan</label>
                                <input type="text" class="form-control @error('nama_pabrikan') is-invalid @enderror" id="nama_pabrikan" name="nama_pabrikan" value="{{ old('nama_pabrikan') }}" placeholder="Contoh: Kimia Farma, Bio Farma">
                            </div>

                            {{-- 16. Peringatan Jumlah (Checkbox + Input Batas Angka) --}}
                            <div class="col-md-4">
                                <label class="form-label d-block">Peringatan Jumlah</label>
                                <div class="d-flex align-items-center gap-2 p-2 border rounded" style="background: #f8fafc;">
                                    <input type="checkbox" id="use_peringatan" class="form-check-input mt-0" checked onchange="togglePeringatanInput(this)">
                                    <label for="use_peringatan" class="form-check-label small fw-semibold text-dark mb-0">Aktifkan</label>
                                    <input type="number" min="1" class="form-control form-control-sm ms-auto" style="width: 85px;" id="peringatan_jumlah" name="peringatan_jumlah" value="{{ old('peringatan_jumlah', 10) }}" placeholder="Batas">
                                </div>
                            </div>

                            {{-- 17. No. Faktur & Tgl. Faktur (Format Tanggal) --}}
                            <div class="col-md-3">
                                <label for="no_faktur" class="form-label">No. Faktur</label>
                                <input type="text" class="form-control @error('no_faktur') is-invalid @enderror" id="no_faktur" name="no_faktur" value="{{ old('no_faktur') }}" placeholder="Nomor faktur">
                            </div>
                            <div class="col-md-3">
                                <label for="tgl_faktur" class="form-label">Tgl_ Faktur</label>
                                <input type="date" class="form-control @error('tgl_faktur') is-invalid @enderror" id="tgl_faktur" name="tgl_faktur" value="{{ old('tgl_faktur') }}">
                            </div>

                            {{-- 18. No. Kontrak & Tgl. Kontrak (Format Tanggal) --}}
                            <div class="col-md-3">
                                <label for="no_kontrak" class="form-label">No. Kontrak</label>
                                <input type="text" class="form-control @error('no_kontrak') is-invalid @enderror" id="no_kontrak" name="no_kontrak" value="{{ old('no_kontrak') }}" placeholder="Nomor kontrak">
                            </div>
                            <div class="col-md-3">
                                <label for="tgl_kontrak" class="form-label">Tgl. Kontrak</label>
                                <input type="date" class="form-control @error('tgl_kontrak') is-invalid @enderror" id="tgl_kontrak" name="tgl_kontrak" value="{{ old('tgl_kontrak') }}">
                            </div>

                            {{-- 19. Gambar Obat/Logistik --}}
                            <div class="col-md-12">
                                <label for="gambar" class="form-label">Gambar Obat/Logistik</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="image-preview-box" id="imagePreviewContainer">
                                        <i class="las la-image text-muted fs-28" id="defaultIcon"></i>
                                        <img src="" alt="Preview" id="imagePreview" style="display: none;">
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this)">
                                        <small class="text-muted d-block mt-1">Pilih Gambar: format JPG, PNG, WEBP (Maksimal 2MB).</small>
                                    </div>
                                </div>
                            </div>

                            {{-- 20. Informasi Lengkap --}}
                            <div class="col-md-12">
                                <label for="informasi_lengkap" class="form-label">Informasi Lengkap</label>
                                <textarea class="form-control @error('informasi_lengkap') is-invalid @enderror" id="informasi_lengkap" name="informasi_lengkap" rows="4" placeholder="Masukkan informasi lengkap / deskripsi obat logistik...">{{ old('informasi_lengkap') }}</textarea>
                            </div>

                        </div>

                        {{-- Submit Button --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('stok-obat.index') }}" class="btn btn-outline-secondary px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn-sifit-submit">
                                <i class="las la-plus-circle fs-18"></i> Tambahkan Obat/Logistik
                            </button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-fill dari Master Obat
        const masterSelect = document.getElementById('master_obat_id');
        const inputKode = document.getElementById('kode_obat_logistik');
        const inputNama = document.getElementById('nama_obat_logistik');
        const inputSatuan = document.getElementById('satuan');
        const inputHarga = document.getElementById('harga_satuan');

        if (masterSelect) {
            masterSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    if (!inputKode.value || inputKode.value.trim() === '') {
                        inputKode.value = selectedOption.getAttribute('data-kode') || '';
                    }
                    if (!inputNama.value || inputNama.value.trim() === '') {
                        inputNama.value = selectedOption.getAttribute('data-nama') || '';
                    }
                    if (selectedOption.getAttribute('data-satuan')) {
                        inputSatuan.value = selectedOption.getAttribute('data-satuan');
                    }
                    if (selectedOption.getAttribute('data-harga')) {
                        inputHarga.value = selectedOption.getAttribute('data-harga');
                    }
                }
            });
        }
    });

    function togglePeringatanInput(checkbox) {
        const inputField = document.getElementById('peringatan_jumlah');
        if (checkbox.checked) {
            inputField.disabled = false;
            if (!inputField.value || inputField.value <= 0) {
                inputField.value = 10;
            }
        } else {
            inputField.disabled = true;
            inputField.value = 0;
        }
    }

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const defaultIcon = document.getElementById('defaultIcon');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (defaultIcon) defaultIcon.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
