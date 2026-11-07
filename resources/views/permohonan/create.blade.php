@extends('layouts.app')
@section('title', 'Buat Permohonan Obat Baru - SIFIT')

@push('css')
<style>
    .select2-container--bootstrap-5 .select2-selection {
        border-color: #dee2e6;
        height: 38px;
    }
    .table-item-obat th, .table-item-obat td {
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Formulir Pengajuan Permohonan Obat</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">Permohonan</a></li>
                            <li class="breadcrumb-item active">Buat Pengajuan</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('permohonan.index') }}" class="btn btn-outline-secondary">
                            <i class="las la-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="las la-exclamation-circle me-1 fs-5 align-middle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="fw-bold mb-1"><i class="las la-exclamation-triangle me-1"></i> Mohon periksa isian formulir:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" id="formPermohonan">
        @csrf
        <div class="row">
            <!-- Informasi Utama Permohonan -->
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="las la-id-card me-1"></i> Data Instansi & Surat
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Instansi / OPD -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Instansi Pemohon (OPD) <span class="text-danger">*</span></label>
                            @if($user->isOpd())
                                <input type="text" class="form-control bg-light" value="{{ $userOpd->nama_opd ?? $user->opd ?? 'Instansi OPD' }}" readonly>
                                <small class="text-muted">Terkunci sesuai akun dinas / instansi Anda.</small>
                            @else
                                <select name="opd_id" class="form-select @error('opd_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih OPD Pemohon --</option>
                                    @foreach($opds as $opd)
                                        <option value="{{ $opd->id }}" {{ old('opd_id') == $opd->id ? 'selected' : '' }}>
                                            {{ $opd->nama_opd }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('opd_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>

                        <!-- Nomor Surat / Permohonan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor Surat Permohonan</label>
                            <input type="text" name="nomor_permohonan" class="form-control" placeholder="Contoh: 440/PKM-TR/X/2026 (Kosongkan utk Auto)" value="{{ old('nomor_permohonan') }}">
                            <small class="text-muted">Dapat diisi nomor surat dinas internal OPD atau dikosongkan untuk generate otomatis.</small>
                        </div>

                        <!-- Tanggal Permohonan -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Permohonan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_permohonan" class="form-control @error('tanggal_permohonan') is-invalid @enderror" value="{{ old('tanggal_permohonan', date('Y-m-d')) }}" required>
                            @error('tanggal_permohonan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keperluan / Program -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Keperluan / Kategori Program</label>
                            <input type="text" name="keperluan" class="form-control" placeholder="Misal: Alokasi Bulanan Puskesmas, Tanggap Darurat..." value="{{ old('keperluan') }}">
                        </div>

                        <!-- Upload Berkas Surat Pengantar -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Lampiran Surat Pengantar (Opsional)</label>
                            <input type="file" name="surat_pengantar" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Format: PDF atau Gambar (Maks. 5 MB).</small>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-0">
                            <label class="form-label fw-semibold">Catatan / Keterangan Tambahan</label>
                            <textarea name="catatan" rows="3" class="form-control" placeholder="Tuliskan catatan atau instruksi khusus untuk UPT Instalasi Farmasi...">{{ old('catatan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Obat yang Dimohonkan -->
            <div class="col-lg-8 col-md-12 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0 fw-bold text-primary">
                                <i class="las la-pills me-1"></i> Rincian Obat yang Dimohonkan
                            </h5>
                            <span class="text-muted small">Pilih obat dan tentukan jumlah yang diajukan</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-success" id="btnTambahObat">
                            <i class="las la-plus me-1"></i> Tambah Baris Obat
                        </button>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-item-obat mb-0" id="tabelItemPermohonan">
                                <thead class="table-light">
                                    <tr>
                                        <th width="45%">Nama Obat / Logistik <span class="text-danger">*</span></th>
                                        <th width="15%">Satuan</th>
                                        <th width="18%">Jumlah Diminta <span class="text-danger">*</span></th>
                                        <th>Catatan Khusus</th>
                                        <th width="6%" class="text-center"><i class="las la-trash"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="itemRowsContainer">
                                    <!-- Baris item dinamis akan dimuat oleh JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3 bg-light border-top d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted">Total Jenis Obat: <strong id="lblTotalJenis">0</strong> | Total Kuantitas: <strong id="lblTotalKuantitas">0</strong> unit</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btnTambahObatBottom">
                                <i class="las la-plus me-1"></i> Tambah Item Lagi
                            </button>
                        </div>
                    </div>

                    <div class="card-footer bg-white py-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('permohonan.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="las la-paper-plane me-1"></i> Kirim Pengajuan Permohonan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Data master obat dari backend
    const masterObats = @json($masterObats);
    let rowIndex = 0;

    function renderObatOptions(selectedId = null) {
        let options = '<option value="">-- Pilih Obat / Barang --</option>';
        masterObats.forEach(obat => {
            const isSel = (selectedId && selectedId == obat.id) ? 'selected' : '';
            const stokText = obat.total_stok > 0 ? `(Tersedia: ${obat.total_stok} ${obat.satuan || ''})` : '(Stok Gudang: 0)';
            options += `<option value="${obat.id}" data-satuan="${obat.satuan || 'Pcs'}" data-stok="${obat.total_stok || 0}" ${isSel}>${obat.nama_obat} - ${stokText}</option>`;
        });
        return options;
    }

    function addRow(selectedObatId = null, qty = 1, catatan = '') {
        const tr = document.createElement('tr');
        tr.id = `row-${rowIndex}`;
        tr.innerHTML = `
            <td>
                <select name="items[${rowIndex}][master_obat_id]" class="form-select select-obat" required onchange="handleObatChange(this, ${rowIndex})">
                    ${renderObatOptions(selectedObatId)}
                </select>
            </td>
            <td>
                <input type="text" class="form-control bg-light input-satuan" id="satuan-${rowIndex}" value="Pcs" readonly>
            </td>
            <td>
                <input type="number" name="items[${rowIndex}][jumlah_diminta]" class="form-control input-qty" min="1" value="${qty}" required oninput="calculateTotals()">
            </td>
            <td>
                <input type="text" name="items[${rowIndex}][catatan]" class="form-control" placeholder="Keterangan..." value="${catatan}">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(${rowIndex})" title="Hapus Baris">
                    <i class="las la-trash"></i>
                </button>
            </td>
        `;
        document.getElementById('itemRowsContainer').appendChild(tr);

        // Set default satuan if obat is preselected
        if (selectedObatId) {
            const selectEl = tr.querySelector('.select-obat');
            handleObatChange(selectEl, rowIndex);
        }

        rowIndex++;
        calculateTotals();
    }

    function removeRow(idx) {
        const row = document.getElementById(`row-${idx}`);
        if (row) {
            row.remove();
            calculateTotals();
        }
    }

    function handleObatChange(selectEl, idx) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const satuan = selectedOption.getAttribute('data-satuan') || 'Pcs';
        const satuanInput = document.getElementById(`satuan-${idx}`);
        if (satuanInput) {
            satuanInput.value = satuan;
        }
    }

    function calculateTotals() {
        const rows = document.querySelectorAll('#itemRowsContainer tr');
        let totalJenis = rows.length;
        let totalQty = 0;

        document.querySelectorAll('.input-qty').forEach(input => {
            const val = parseInt(input.value) || 0;
            totalQty += val;
        });

        document.getElementById('lblTotalJenis').textContent = totalJenis;
        document.getElementById('lblTotalKuantitas').textContent = totalQty.toLocaleString('id-ID');
    }

    document.getElementById('btnTambahObat').addEventListener('click', () => addRow());
    document.getElementById('btnTambahObatBottom').addEventListener('click', () => addRow());

    // Inisialisasi awal dengan 2 baris
    document.addEventListener('DOMContentLoaded', function() {
        addRow();
        addRow();
    });
</script>
@endpush
