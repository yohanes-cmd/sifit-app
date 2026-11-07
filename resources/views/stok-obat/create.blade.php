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

                    <form action="{{ route('stok-obat.store') }}" method="POST" enctype="multipart/form-data" id="formStokObat">
                        @csrf

                        {{-- Mode Selector: Unified In-Stock Creation --}}
                        <div class="card bg-light border-0 mb-4 p-3 rounded-3 shadow-none">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <span class="badge bg-primary px-2 py-1 mb-1">Alur Terpadu Farmasi SIFIT</span>
                                    <h6 class="fw-bold mb-1 text-dark">Sumber Data Master Obat / Logistik</h6>
                                    <p class="text-muted small mb-0">Semua item persediaan baru kini dapat didaftarkan langsung dari formulir stok ini tanpa berpindah halaman.</p>
                                </div>
                                <div class="col-md-5 text-md-end mt-2 mt-md-0">
                                    <div class="btn-group w-100 w-md-auto" role="group">
                                        <input type="radio" class="btn-check" name="mode_master_radio" id="modePilihMaster" value="existing" autocomplete="off" {{ old('is_new_master') == '1' ? '' : 'checked' }} onchange="switchModeMaster('existing')">
                                        <label class="btn btn-outline-primary btn-sm px-3 fw-semibold" for="modePilihMaster">
                                            <i class="las la-list me-1"></i> Pilih Master yang Ada
                                        </label>

                                        <input type="radio" class="btn-check" name="mode_master_radio" id="modeMasterBaru" value="new" autocomplete="off" {{ old('is_new_master') == '1' ? 'checked' : '' }} onchange="switchModeMaster('new')">
                                        <label class="btn btn-outline-success btn-sm px-3 fw-semibold" for="modeMasterBaru">
                                            <i class="las la-plus-circle me-1"></i> + Buat Master Baru Sekaligus
                                        </label>
                                    </div>
                                    <input type="hidden" name="is_new_master" id="is_new_master" value="{{ old('is_new_master', '0') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Section A: Mode Master Baru Sekaligus (Collapsible) --}}
                        <div id="sectionMasterBaru" class="card border border-success-subtle bg-white p-3 mb-4 rounded-3 shadow-sm" style="{{ old('is_new_master') == '1' ? 'display: block;' : 'display: none;' }}">
                            <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                <span class="badge bg-success me-2 p-2"><i class="las la-pills fs-16"></i></span>
                                <div>
                                    <h6 class="fw-bold mb-0 text-success">Registrasi Master Obat / Logistik Baru</h6>
                                    <small class="text-muted">Item ini akan otomatis tersimpan ke Master Data dan siap digunakan untuk permohonan logistik farmasi.</small>
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Hidden status default published untuk permohonan distribusi --}}
                                <input type="hidden" name="new_status" value="published">

                                {{-- Kategori Master --}}
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Barang <span class="text-danger">*</span></label>
                                    <select class="form-select" name="new_kategori" id="new_kategori" onchange="handleNewKategoriChange()">
                                        <option value="Obat" {{ old('new_kategori', 'Obat') == 'Obat' ? 'selected' : '' }}>Obat Medis</option>
                                        <option value="Logistik" {{ old('new_kategori') == 'Logistik' ? 'selected' : '' }}>Logistik Medis / Alkes</option>
                                    </select>
                                </div>

                                {{-- Kode Obat Baru --}}
                                <div class="col-md-4">
                                    <label class="form-label">Kode Master Baru <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="new_kode_obat" id="new_kode_obat" value="{{ old('new_kode_obat', $nextCode ?? '') }}" placeholder="Contoh: 00045">
                                        <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('new_kode_obat').value = '{{ $nextCode ?? '' }}'" title="Gunakan Kode Auto">Auto</button>
                                    </div>
                                    <small class="text-muted" style="font-size: 11px;">Kode unik identifikasi master obat.</small>
                                </div>

                                {{-- Nama Obat Baru --}}
                                <div class="col-md-5">
                                    <label class="form-label">Nama Obat / Logistik Baru <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="new_nama_obat" id="new_nama_obat" value="{{ old('new_nama_obat') }}" placeholder="Contoh: Paracetamol 500mg Tablet">
                                </div>

                                {{-- Batch Obat / Kode Kemkes --}}
                                <div class="col-md-4">
                                    <label class="form-label" id="labelNewKodeKemkes">Batch Obat</label>
                                    <input type="text" class="form-control" name="new_kode_kemkes" id="new_kode_kemkes" value="{{ old('new_kode_kemkes') }}" placeholder="Contoh: BATCH-001">
                                    <small class="text-muted" id="helpNewKodeKemkes" style="font-size: 11px;">Nomor batch produksi master obat.</small>
                                </div>

                                {{-- Satuan --}}
                                <div class="col-md-4">
                                    <label class="form-label">Satuan Master Distribusi</label>
                                    <input type="text" class="form-control" name="new_satuan" id="new_satuan" value="{{ old('new_satuan', 'Tablet') }}" placeholder="Tablet / Botol / Vial / Box">
                                </div>

                                {{-- Harga / Standar Biaya --}}
                                <div class="col-md-4">
                                    <label class="form-label">Standar Biaya / HET (Rp)</label>
                                    <input type="number" class="form-control" name="new_harga" id="new_harga" value="{{ old('new_harga', 0) }}" min="0" placeholder="0">
                                </div>

                                {{-- Golongan Obat & Resep --}}
                                <div class="col-md-6" id="wrapperGolonganObat">
                                    <label class="form-label">Golongan Obat (Regulasi Dinkes)</label>
                                    <select class="form-select" name="new_golongan_obat" id="new_golongan_obat" onchange="handleNewGolonganChange()">
                                        <option value="Obat Bebas" {{ old('new_golongan_obat') == 'Obat Bebas' ? 'selected' : '' }}>Obat Bebas (Lingkaran Hijau)</option>
                                        <option value="Obat Bebas Terbatas" {{ old('new_golongan_obat') == 'Obat Bebas Terbatas' ? 'selected' : '' }}>Obat Bebas Terbatas (Lingkaran Biru)</option>
                                        <option value="Obat Keras" {{ old('new_golongan_obat') == 'Obat Keras' ? 'selected' : '' }}>Obat Keras (Lingkaran Merah - K)</option>
                                    </select>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="new_requires_prescription" id="new_requires_prescription" value="1" {{ old('new_requires_prescription') ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="new_requires_prescription" id="labelNewPrescription">
                                            Wajib Resep Dokter / Rekomendasi Medis
                                        </label>
                                    </div>
                                </div>

                                {{-- Upload Foto Master --}}
                                <div class="col-md-6">
                                    <label class="form-label">Foto / Dokumen Master Obat (Opsional)</label>
                                    <input type="file" class="form-control" name="new_gambar" accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <small class="text-muted" style="font-size: 11px;">Maksimal 2MB (JPG, PNG, WebP).</small>
                                </div>

                                {{-- Deskripsi / Indikasi --}}
                                <div class="col-12">
                                    <label class="form-label">Deskripsi / Indikasi Obat</label>
                                    <textarea class="form-control" name="new_deskripsi" rows="2" placeholder="Komposisi, indikasi medis, aturan simpan...">{{ old('new_deskripsi') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">

                            {{-- 1. Master Obat/Logistik Selection (Dropdown auto-fill) --}}
                            <div class="col-md-6" id="sectionMasterExisting" style="{{ old('is_new_master') == '1' ? 'display: none;' : 'display: block;' }}">
                                <label for="master_obat_id" class="form-label">Master Obat/Logistik <span class="text-danger">*</span></label>
                                <select class="form-select @error('master_obat_id') is-invalid @enderror" id="master_obat_id" name="master_obat_id" {{ old('is_new_master') == '1' ? '' : 'required' }}>
                                    <option value="">-- Pilih Master Obat/Logistik --</option>
                                    @foreach($masterObats as $master)
                                        <option value="{{ $master->id }}" 
                                                data-kode="{{ $master->kode_obat }}"
                                                data-nama="{{ $master->nama_obat }}"
                                                data-kategori="{{ $master->kategori }}"
                                                data-batch="{{ $master->kode_kemkes }}"
                                                data-satuan="{{ $master->satuan }}"
                                                data-harga="{{ $master->harga }}"
                                                {{ old('master_obat_id') == $master->id ? 'selected' : '' }}>
                                            {{ $master->kode_obat }} - {{ $master->nama_obat }} ({{ $master->satuan }})@if($master->kode_kemkes) - [{{ $master->kategori == 'Logistik' ? 'Kemkes: ' : 'Batch: ' }}{{ $master->kode_kemkes }}]@endif
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
    function switchModeMaster(mode) {
        const isNewInput = document.getElementById('is_new_master');
        const sectionNew = document.getElementById('sectionMasterBaru');
        const sectionExisting = document.getElementById('sectionMasterExisting');
        const masterSelect = document.getElementById('master_obat_id');
        const inputNewNama = document.getElementById('new_nama_obat');
        const inputNewKode = document.getElementById('new_kode_obat');

        if (mode === 'new') {
            if (isNewInput) isNewInput.value = '1';
            if (sectionNew) sectionNew.style.display = 'block';
            if (sectionExisting) sectionExisting.style.display = 'none';
            if (masterSelect) {
                masterSelect.removeAttribute('required');
                masterSelect.value = '';
            }
            if (inputNewNama) inputNewNama.setAttribute('required', 'required');
            if (inputNewKode) inputNewKode.setAttribute('required', 'required');
        } else {
            if (isNewInput) isNewInput.value = '0';
            if (sectionNew) sectionNew.style.display = 'none';
            if (sectionExisting) sectionExisting.style.display = 'block';
            if (masterSelect) masterSelect.setAttribute('required', 'required');
            if (inputNewNama) inputNewNama.removeAttribute('required');
            if (inputNewKode) inputNewKode.removeAttribute('required');
        }
    }

    function handleNewKategoriChange() {
        const kat = document.getElementById('new_kategori')?.value;
        const wrapperGol = document.getElementById('wrapperGolonganObat');
        if (wrapperGol) {
            wrapperGol.style.display = (kat === 'Logistik') ? 'none' : 'block';
        }

        const labelNew = document.getElementById('labelNewKodeKemkes');
        const inputNew = document.getElementById('new_kode_kemkes');
        const helpNew = document.getElementById('helpNewKodeKemkes');
        if (kat === 'Logistik') {
            if (labelNew) labelNew.textContent = 'Kode Kemkes / KFA';
            if (inputNew) inputNew.placeholder = 'Contoh: 93001234 / KRD, KN';
            if (helpNew) helpNew.textContent = 'Kode standarisasi Kementerian Kesehatan / KFA logistik.';
        } else {
            if (labelNew) labelNew.textContent = 'Batch Obat';
            if (inputNew) inputNew.placeholder = 'Contoh: BATCH-001';
            if (helpNew) helpNew.textContent = 'Nomor batch produksi master obat.';
        }
    }

    function handleNewGolonganChange() {
        const gol = document.getElementById('new_golongan_obat')?.value;
        const checkPrescription = document.getElementById('new_requires_prescription');
        const labelPrescription = document.getElementById('labelNewPrescription');

        if (gol === 'Obat Keras') {
            if (checkPrescription) {
                checkPrescription.checked = true;
                checkPrescription.disabled = true;
            }
            if (labelPrescription) {
                labelPrescription.innerHTML = '<strong>Wajib Resep Dokter</strong> <span class="badge bg-danger ms-1">Terkunci (Regulasi Obat Keras)</span>';
            }
        } else {
            if (checkPrescription) {
                checkPrescription.disabled = false;
            }
            if (labelPrescription) {
                labelPrescription.innerHTML = 'Wajib Resep Dokter untuk Permohonan Publik';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Cek inisialisasi awal mode
        const isNew = document.getElementById('is_new_master')?.value;
        if (isNew === '1') {
            switchModeMaster('new');
        } else {
            switchModeMaster('existing');
        }

        handleNewKategoriChange();
        handleNewGolonganChange();

        // Auto-fill dari Master Obat yang dipilih
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
                    const kat = selectedOption.getAttribute('data-kategori');
                    const batchOrKemkes = selectedOption.getAttribute('data-batch');
                    const inputNoBatch = document.getElementById('no_batch');
                    if (kat === 'Obat' && batchOrKemkes && inputNoBatch) {
                        if (!inputNoBatch.value || inputNoBatch.dataset.autoSync === 'true') {
                            inputNoBatch.value = batchOrKemkes;
                            inputNoBatch.dataset.autoSync = 'true';
                        }
                    }
                }
            });
        }

        // Sinkronisasi isian master baru ke input manual stok fisik jika kosong
        const inputNewNama = document.getElementById('new_nama_obat');
        const inputNewKode = document.getElementById('new_kode_obat');
        const inputNewSatuan = document.getElementById('new_satuan');
        const inputNewHarga = document.getElementById('new_harga');

        if (inputNewNama) {
            inputNewNama.addEventListener('input', function() {
                if (document.getElementById('is_new_master')?.value === '1') {
                    if (inputNama) inputNama.value = this.value;
                }
            });
        }

        if (inputNewKode) {
            inputNewKode.addEventListener('input', function() {
                if (document.getElementById('is_new_master')?.value === '1') {
                    if (inputKode) inputKode.value = this.value;
                }
            });
        }

        if (inputNewSatuan) {
            inputNewSatuan.addEventListener('input', function() {
                if (document.getElementById('is_new_master')?.value === '1') {
                    if (inputSatuan) inputSatuan.value = this.value;
                }
            });
        }

        if (inputNewHarga) {
            inputNewHarga.addEventListener('input', function() {
                if (document.getElementById('is_new_master')?.value === '1') {
                    if (inputHarga && (!inputHarga.value || inputHarga.value === '0')) {
                        inputHarga.value = this.value;
                    }
                }
            });
        }

        const inputNewBatch = document.getElementById('new_kode_kemkes');
        const inputNoBatch = document.getElementById('no_batch');
        if (inputNewBatch && inputNoBatch) {
            inputNewBatch.addEventListener('input', function() {
                if (document.getElementById('is_new_master')?.value === '1') {
                    const kat = document.getElementById('new_kategori')?.value;
                    if (kat === 'Obat') {
                        if (!inputNoBatch.value || inputNoBatch.dataset.autoSync === 'true') {
                            inputNoBatch.value = this.value;
                            inputNoBatch.dataset.autoSync = 'true';
                        }
                    }
                }
            });
            inputNoBatch.addEventListener('input', function() {
                this.dataset.autoSync = 'false';
            });
        }

        // Form submit safety: pastikan disabled checkbox nilainya tetap dikirim
        const form = document.getElementById('formStokObat');
        if (form) {
            form.addEventListener('submit', function() {
                const checkPrescription = document.getElementById('new_requires_prescription');
                if (checkPrescription && checkPrescription.disabled) {
                    checkPrescription.disabled = false; // Aktifkan sebentar sebelum submit agar nilainya terkirim
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
