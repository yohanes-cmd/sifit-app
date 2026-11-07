@extends('layouts.app') 
@section('title', 'Tambah Pengeluaran (SBBK) - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tambah Pengeluaran Barang (SBBK)</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pengeluaran.index') }}">Pengeluaran Barang</a></li>
                            <li class="breadcrumb-item active">Tambah SBBK</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center">
                        <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-secondary">
                            <i class="las la-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="las la-file-invoice me-1"></i> Form Surat Bukti Barang Keluar (SBBK)
                        </h5>
                        <p class="text-muted mb-0 small">Kalkulasi dan pengurangan stok per nomor batch diproses otomatis secara presisi.</p>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="las la-check-circle me-1 fs-5 align-middle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="las la-exclamation-circle me-1 fs-5 align-middle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="fw-bold mb-1"><i class="las la-exclamation-triangle me-1"></i> Terjadi Kesalahan Validasi:</h6>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- PILIHAN JALUR PENGELUARAN (REVISI BARU) -->
                    <div class="card bg-light border-0 mb-4 p-3 rounded">
                        <div class="row align-items-center">
                            <div class="col-md-5 mb-2 mb-md-0">
                                <label class="form-label fw-bold text-dark mb-1">
                                    <i class="las la-route text-primary me-1 fs-5"></i> Jalur Pengeluaran Barang
                                </label>
                                <p class="text-muted small mb-0">Pilih apakah pengeluaran ini memproses <strong>Permohonan OPD</strong> atau <strong>Surat Langsung</strong>.</p>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="las la-exchange-alt"></i></span>
                                    <select class="form-select fw-semibold" id="selectSumberPengeluaran" onchange="handleSumberChange(this.value)">
                                        <option value="" {{ empty($selectedPermohonan) ? 'selected' : '' }}>
                                            📄 Jalur Surat Dinas Langsung (Reguler)
                                        </option>
                                        @if(isset($permohonanList) && $permohonanList->count() > 0)
                                            <optgroup label="-- Realisasikan Permohonan OPD --">
                                                @foreach($permohonanList as $prm)
                                                    <option value="{{ $prm->id }}" {{ (!empty($selectedPermohonan) && $selectedPermohonan->id == $prm->id) ? 'selected' : '' }}>
                                                        📋 No. {{ $prm->nomor_permohonan }} - {{ $prm->opd->nama_opd ?? 'OPD' }} ({{ \Carbon\Carbon::parse($prm->tanggal_permohonan)->format('d/m/Y') }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!empty($selectedPermohonan))
                        <div class="alert alert-info border-0 shadow-sm mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0 text-primary">
                                    <i class="las la-clipboard-check me-1 fs-5"></i> Acuan Barang dari Permohonan: {{ $selectedPermohonan->nomor_permohonan }}
                                </h6>
                                <span class="badge bg-primary">{{ $selectedPermohonan->status_label }}</span>
                            </div>
                            <p class="mb-2 small">Instansi Pemohon: <strong>{{ $selectedPermohonan->opd->nama_opd ?? '-' }}</strong> | Tanggal Permohonan: {{ \Carbon\Carbon::parse($selectedPermohonan->tanggal_permohonan)->translatedFormat('d F Y') }}</p>
                            <div class="table-responsive bg-white rounded border">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Obat yang Dimohonkan</th>
                                            <th class="text-center" width="20%">Kuantitas Diminta</th>
                                            <th class="text-center" width="20%">Kuantitas Disetujui</th>
                                            <th>Keterangan Permohonan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($selectedPermohonan->detailPermohonans as $prmDetail)
                                            <tr>
                                                <td><strong>{{ $prmDetail->masterObat->nama_obat ?? '-' }}</strong></td>
                                                <td class="text-center">{{ number_format($prmDetail->jumlah_diminta) }} {{ $prmDetail->masterObat->satuan ?? 'Pcs' }}</td>
                                                <td class="text-center fw-bold text-success">{{ number_format($prmDetail->jumlah_disetujui ?? $prmDetail->jumlah_diminta) }} {{ $prmDetail->masterObat->satuan ?? 'Pcs' }}</td>
                                                <td class="small text-muted">{{ $prmDetail->catatan ?: '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('pengeluaran.store') }}" method="POST" id="formPengeluaran">
                        @csrf
                        @if(!empty($selectedPermohonan))
                            <input type="hidden" name="permohonan_id" value="{{ $selectedPermohonan->id }}">
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Surat (SBBK) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 442/SBBK/DINKES/2026" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Program <span class="text-danger">*</span></label>
                                <select class="form-select" name="program_id" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($programs ?? [] as $program)
                                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                            {{ $program->nama }} {{ $program->kode ? '('.$program->kode.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gudang Sumber (Asal) <span class="text-danger">*</span></label>
                                <select class="form-select" name="gudang_id" id="gudang_id" required onchange="handleGudangChange()">
                                    <option value="">-- Pilih Gudang Sumber --</option>
                                    @foreach($gudangs as $gudang)
                                        <option value="{{ $gudang->id }}" {{ old('gudang_id') == $gudang->id ? 'selected' : '' }}>
                                            {{ $gudang->nama_gudang }} ({{ strtoupper($gudang->tipe) }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted d-block mt-1">Stok obat dan pilihan nomor batch akan dimuat berdasarkan gudang yang dipilih.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Pengangkut / Kurir <span class="text-danger">*</span></label>
                                <select class="form-select" name="pengangkut_id" required>
                                    <option value="">-- Pilih Pengangkut --</option>
                                    @foreach($pengangkuts ?? [] as $pengangkut)
                                        <option value="{{ $pengangkut->id }}" {{ old('pengangkut_id') == $pengangkut->id ? 'selected' : '' }}>
                                            {{ $pengangkut->nama }} {{ $pengangkut->jenis_kendaraan ? '('.$pengangkut->jenis_kendaraan.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Instansi Penerima (OPD / Puskesmas) <span class="text-danger">*</span></label>
                                <select class="form-select" name="instansi_id" required>
                                    <option value="">-- Pilih Instansi Penerima --</option>
                                    @foreach($instansis ?? [] as $instansi)
                                        <option value="{{ $instansi->id }}" {{ old('instansi_id', $selectedPermohonan->opd_id ?? '') == $instansi->id ? 'selected' : '' }}>
                                            {{ $instansi->nama_opd }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Pajak Invoice <span class="text-danger">*</span></label>
                                <select class="form-select" name="pajak_invoice" id="pajak_invoice" required onchange="calculateTotal()">
                                    <option value="NO TAX" {{ old('pajak_invoice', 'NO TAX') == 'NO TAX' ? 'selected' : '' }}>No Tax (0%)</option>
                                    <option value="VAT" {{ old('pajak_invoice') == 'VAT' ? 'selected' : '' }}>VAT (PPN 11%)</option>
                                    <option value="GST" {{ old('pajak_invoice') == 'GST' ? 'selected' : '' }}>GST (10%)</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-0"><i class="las la-boxes me-2"></i>Daftar Item Obat / Logistik Keluar</h5>
                                <small class="text-muted">Pilih obat dan nomor batch yang dikeluarkan. Stok otomatis berkurang sesuai nomor batch yang dipilih.</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="btnTambahItem" onclick="addItemRow()">
                                <i class="las la-plus me-1"></i> Tambah Item
                            </button>
                        </div>

                        <div id="gudangNotice" class="alert alert-warning d-flex align-items-center py-2 mb-3" style="display: none;">
                            <i class="las la-info-circle fs-4 me-2"></i>
                            <div>Silakan pilih <strong>Gudang Sumber</strong> terlebih dahulu untuk menambahkan barang keluar.</div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover align-middle" id="tableItems">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 28%;">Nama Obat / Logistik <span class="text-danger">*</span></th>
                                        <th style="width: 24%;">Nomor Batch & Kadaluarsa <span class="text-danger">*</span></th>
                                        <th style="width: 10%;">Satuan</th>
                                        <th style="width: 13%;">Jumlah Keluar <span class="text-danger">*</span></th>
                                        <th style="width: 13%;">Harga Satuan (Rp) <span class="text-danger">*</span></th>
                                        <th style="width: 12%;">Subtotal (Rp)</th>
                                        <th style="width: 5%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <!-- Dynamic rows inserted here -->
                                </tbody>
                            </table>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Catatan / Keterangan SBBK</label>
                                <textarea class="form-control" name="catatan" rows="4" placeholder="Catatan internal pengeluaran barang, keperluan distribusi, dsb...">{{ old('catatan') }}</textarea>
                            </div>
                            <div class="col-md-5">
                                <div class="card bg-light border p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Subtotal Item:</span>
                                        <span class="fw-semibold" id="displaySubtotal">Rp 0</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted" id="labelPajak">Pajak (0%):</span>
                                        <span class="fw-semibold text-info" id="displayPajak">Rp 0</span>
                                    </div>
                                    <div class="mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="text-muted">Biaya Kirim:</span>
                                            <div class="input-group input-group-sm" style="max-width: 170px;">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control text-end" name="biaya_kirim" id="biayaKirimInput" value="{{ old('biaya_kirim', 0) }}" min="0" oninput="calculateTotal()">
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold fs-6 text-dark">Total Tagihan:</span>
                                        <span class="fw-bold fs-5 text-primary" id="displayTotalTagihan">Rp 0</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary px-3">
                                <i class="las la-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold" id="btnSubmit">
                                <i class="las la-paper-plane me-1"></i> Simpan SBBK
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="rowTemplate">
    <tr class="item-row">
        <td>
            <select class="form-select select-obat" name="master_obat_id[]" required onchange="onObatSelect(this)">
                <option value="">-- Pilih Obat / Logistik --</option>
            </select>
            <div class="small text-muted mt-1 obat-desc-text"></div>
        </td>
        <td>
            <select class="form-select select-batch" name="no_batch[]" required onchange="onBatchSelect(this)">
                <option value="">-- Pilih Batch --</option>
            </select>
            <div class="small mt-1 batch-info-text"></div>
        </td>
        <td>
            <input type="text" class="form-control bg-light input-satuan" readonly placeholder="-">
        </td>
        <td>
            <input type="number" class="form-control input-jumlah" name="jumlah[]" min="1" placeholder="0" required oninput="onJumlahChange(this)">
            <div class="stock-feedback small text-muted mt-1"></div>
        </td>
        <td>
            <div class="input-group">
                <span class="input-group-text px-1">Rp</span>
                <input type="number" class="form-control input-harga" name="harga_satuan[]" min="0" placeholder="0" required oninput="onHargaChange(this)">
            </div>
        </td>
        <td>
            <input type="text" class="form-control bg-light text-end input-subtotal" readonly value="Rp 0">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" onclick="removeItemRow(this)" title="Hapus Baris">
                <i class="las la-trash"></i>
            </button>
        </td>
    </tr>
</template>

@endsection

@push('scripts')
<script>
    // Menyimpan daftar stok aktif untuk gudang yang sedang dipilih
    let currentGudangStocks = [];
    let isFetchingStocks = false;

    // Data input lama jika terjadi validasi error
    const oldItemsData = {
        master_obat_id: @json(old('master_obat_id', [])),
        no_batch: @json(old('no_batch', [])),
        jumlah: @json(old('jumlah', [])),
        harga_satuan: @json(old('harga_satuan', []))
    };

    function formatRupiah(number) {
        return 'Rp ' + Number(number || 0).toLocaleString('id-ID');
    }

    function checkGudangNotice() {
        const gudangId = document.getElementById('gudang_id').value;
        const notice = document.getElementById('gudangNotice');
        const btnTambah = document.getElementById('btnTambahItem');

        if (!gudangId) {
            if (notice) notice.style.display = 'flex';
            if (btnTambah) btnTambah.disabled = true;
        } else {
            if (notice) notice.style.display = 'none';
            if (btnTambah) btnTambah.disabled = false;
        }
    }

    function handleGudangChange(isInitialLoad = false) {
        const gudangId = document.getElementById('gudang_id').value;
        checkGudangNotice();

        const container = document.getElementById('itemContainer');

        if (!gudangId) {
            currentGudangStocks = [];
            container.innerHTML = '';
            calculateTotal();
            return;
        }

        // Jika bukan inisialisasi awal dan sudah ada item, konfirmasi penggantian
        if (!isInitialLoad && container.querySelectorAll('.item-row').length > 0) {
            if (!confirm('Mengubah Gudang Sumber akan mereset item yang sudah ditambahkan karena stok bergantung pada gudang asal. Lanjutkan?')) {
                return;
            }
            container.innerHTML = '';
        }

        isFetchingStocks = true;
        const btnSubmit = document.getElementById('btnSubmit');
        if (btnSubmit) btnSubmit.disabled = true;

        fetch(`/pengeluaran/stok-by-gudang/${gudangId}`)
            .then(res => res.json())
            .then(data => {
                currentGudangStocks = data.stocks || [];
                isFetchingStocks = false;
                if (btnSubmit) btnSubmit.disabled = false;

                if (isInitialLoad && oldItemsData.master_obat_id && oldItemsData.master_obat_id.length > 0) {
                    restoreOldRows();
                } else if (container.querySelectorAll('.item-row').length === 0) {
                    addItemRow();
                } else {
                    // Update dropdowns in existing rows
                    container.querySelectorAll('.item-row').forEach(row => {
                        populateObatSelect(row);
                    });
                }
            })
            .catch(err => {
                console.error('Gagal mengambil data stok gudang:', err);
                isFetchingStocks = false;
                if (btnSubmit) btnSubmit.disabled = false;
                alert('Gagal memuat data stok dari gudang ini. Silakan periksa koneksi atau coba lagi.');
            });
    }

    function populateObatSelect(row, selectedObatId = '') {
        const selectObat = row.querySelector('.select-obat');
        if (!selectObat) return;

        // Kumpulkan obat unik yang tersedia di gudang ini
        const uniqueObats = [];
        const seenIds = new Set();

        currentGudangStocks.forEach(s => {
            if (!seenIds.has(s.master_obat_id)) {
                seenIds.add(s.master_obat_id);
                // Hitung total stok obat ini di gudang
                const totalStok = currentGudangStocks
                    .filter(item => item.master_obat_id === s.master_obat_id)
                    .reduce((acc, item) => acc + item.jumlah, 0);

                uniqueObats.push({
                    id: s.master_obat_id,
                    nama: s.nama_obat,
                    kode: s.kode_obat,
                    kategori: s.kategori,
                    kode_kemkes: s.kode_kemkes,
                    satuan: s.satuan,
                    totalStok: totalStok
                });
            }
        });

        uniqueObats.sort((a, b) => a.nama.localeCompare(b.nama));

        let options = '<option value="">-- Pilih Obat / Logistik --</option>';
        uniqueObats.forEach(obat => {
            const isSelected = String(obat.id) === String(selectedObatId) ? 'selected' : '';
            const kemkesInfo = (obat.kategori === 'Logistik' && obat.kode_kemkes) ? ` [Kemkes: ${obat.kode_kemkes}]` : '';
            options += `<option value="${obat.id}" ${isSelected}>${obat.nama} (${obat.kode})${kemkesInfo} - Total Stok: ${obat.totalStok} ${obat.satuan}</option>`;
        });

        if (uniqueObats.length === 0) {
            options = '<option value="">(Tidak ada stok obat di gudang ini)</option>';
        }

        selectObat.innerHTML = options;
    }

    function onObatSelect(selectElem, preselectedBatch = '') {
        const row = selectElem.closest('tr');
        const obatId = selectElem.value;
        const selectBatch = row.querySelector('.select-batch');
        const inputSatuan = row.querySelector('.input-satuan');
        const inputHarga = row.querySelector('.input-harga');
        const inputJumlah = row.querySelector('.input-jumlah');
        const stockFeedback = row.querySelector('.stock-feedback');

        if (!obatId) {
            selectBatch.innerHTML = '<option value="">-- Pilih Batch --</option>';
            if (inputSatuan) inputSatuan.value = '';
            if (inputHarga) inputHarga.value = '0';
            if (inputJumlah) {
                inputJumlah.value = '';
                inputJumlah.removeAttribute('max');
            }
            if (stockFeedback) stockFeedback.innerHTML = '';
            updateRowSubtotal(row);
            calculateTotal();
            return;
        }

        // Ambil semua batch untuk obat ini di gudang yang dipilih
        const batches = currentGudangStocks.filter(s => String(s.master_obat_id) === String(obatId));

        let batchOptions = '<option value="">-- Pilih Nomor Batch --</option>';
        batches.forEach(b => {
            const isSelected = (preselectedBatch && b.no_batch === preselectedBatch) ? 'selected' : '';
            batchOptions += `<option value="${b.no_batch}" data-exp="${b.exp_date_formatted || '-'}" data-stok="${b.jumlah}" data-harga="${b.harga_satuan || 0}" data-satuan="${b.satuan}" ${isSelected}>
                ${b.no_batch} | Exp: ${b.exp_date_formatted || '-'} | Sisa: ${b.jumlah} ${b.satuan}
            </option>`;
        });

        selectBatch.innerHTML = batchOptions;

        // Jika hanya ada 1 batch dan belum dipilih, pilih otomatis
        if (batches.length === 1 && !preselectedBatch) {
            selectBatch.selectedIndex = 1;
            onBatchSelect(selectBatch);
        } else if (preselectedBatch) {
            onBatchSelect(selectBatch);
        } else {
            if (inputSatuan) inputSatuan.value = batches[0]?.satuan || '';
            if (inputHarga) inputHarga.value = batches[0]?.harga_satuan || 0;
            if (stockFeedback) stockFeedback.innerHTML = '';
        }

        updateRowSubtotal(row);
        calculateTotal();
    }

    function onBatchSelect(selectElem) {
        const row = selectElem.closest('tr');
        const selectedOption = selectElem.options[selectElem.selectedIndex];
        const inputSatuan = row.querySelector('.input-satuan');
        const inputHarga = row.querySelector('.input-harga');
        const inputJumlah = row.querySelector('.input-jumlah');
        const batchInfoText = row.querySelector('.batch-info-text');
        const stockFeedback = row.querySelector('.stock-feedback');

        if (!selectElem.value) {
            if (batchInfoText) batchInfoText.innerHTML = '';
            if (stockFeedback) stockFeedback.innerHTML = '';
            if (inputJumlah) inputJumlah.removeAttribute('max');
            return;
        }

        const exp = selectedOption.getAttribute('data-exp') || '-';
        const stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
        const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        const satuan = selectedOption.getAttribute('data-satuan') || '';

        if (inputSatuan) inputSatuan.value = satuan;
        if (inputHarga) inputHarga.value = harga;

        if (inputJumlah) {
            inputJumlah.setAttribute('max', stok);
            if (parseInt(inputJumlah.value) > stok) {
                inputJumlah.value = stok;
            }
        }

        if (batchInfoText) {
            batchInfoText.innerHTML = `<span class="badge bg-light text-dark border">Kadaluarsa: ${exp}</span>`;
        }

        if (stockFeedback) {
            stockFeedback.innerHTML = `<span class="badge bg-info-subtle text-info fw-semibold"><i class="las la-box"></i> Stok Tersedia: ${stok} ${satuan}</span>`;
        }

        onJumlahChange(inputJumlah);
    }

    function onJumlahChange(inputElem) {
        if (!inputElem) return;
        const row = inputElem.closest('tr');
        const maxStok = parseInt(inputElem.getAttribute('max')) || 0;
        const currentQty = parseInt(inputElem.value) || 0;
        const stockFeedback = row.querySelector('.stock-feedback');

        if (maxStok > 0 && currentQty > maxStok) {
            inputElem.classList.add('is-invalid');
            if (stockFeedback) {
                stockFeedback.innerHTML = `<span class="badge bg-danger text-white"><i class="las la-exclamation-circle"></i> Melebihi stok! Maks: ${maxStok}</span>`;
            }
        } else {
            inputElem.classList.remove('is-invalid');
            if (stockFeedback && maxStok > 0) {
                const sisa = maxStok - currentQty;
                stockFeedback.innerHTML = `<span class="badge bg-info-subtle text-info fw-semibold">Sisa setelah keluar: ${sisa}</span>`;
            }
        }

        updateRowSubtotal(row);
        calculateTotal();
    }

    function onHargaChange(inputElem) {
        if (!inputElem) return;
        const row = inputElem.closest('tr');
        updateRowSubtotal(row);
        calculateTotal();
    }

    function updateRowSubtotal(row) {
        const qty = parseFloat(row.querySelector('.input-jumlah')?.value) || 0;
        const harga = parseFloat(row.querySelector('.input-harga')?.value) || 0;
        const subtotal = qty * harga;
        const subtotalElem = row.querySelector('.input-subtotal');
        if (subtotalElem) {
            subtotalElem.value = formatRupiah(subtotal);
        }
    }

    function addItemRow() {
        const gudangId = document.getElementById('gudang_id').value;
        if (!gudangId) {
            alert('Silakan pilih Gudang Sumber terlebih dahulu sebelum menambah item.');
            document.getElementById('gudang_id').focus();
            return;
        }

        const template = document.getElementById('rowTemplate').innerHTML;
        const container = document.getElementById('itemContainer');
        container.insertAdjacentHTML('beforeend', template);

        const newRow = container.lastElementChild;
        populateObatSelect(newRow);
        updateRemoveButtons();
    }

    function removeItemRow(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('tr').remove();
            updateRemoveButtons();
            calculateTotal();
        } else {
            alert('Minimal 1 item obat harus ada.');
        }
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            const btn = row.querySelector('.btn-remove-row');
            if (btn) {
                if (rows.length === 1) {
                    btn.setAttribute('disabled', 'disabled');
                } else {
                    btn.removeAttribute('disabled');
                }
            }
        });
    }

    function calculateTotal() {
        let subtotal = 0;
        const rows = document.querySelectorAll('.item-row');

        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.input-jumlah')?.value) || 0;
            const harga = parseFloat(row.querySelector('.input-harga')?.value) || 0;
            subtotal += (qty * harga);
        });

        const pajakType = document.getElementById('pajak_invoice')?.value || 'NO TAX';
        let pajakPersen = 0;
        if (pajakType === 'VAT') {
            pajakPersen = 0.11;
        } else if (pajakType === 'GST') {
            pajakPersen = 0.10;
        }

        const nominalPajak = subtotal * pajakPersen;
        const biayaKirim = parseFloat(document.getElementById('biayaKirimInput')?.value) || 0;
        const grandTotal = subtotal + nominalPajak + biayaKirim;

        const displaySubtotal = document.getElementById('displaySubtotal');
        const labelPajak = document.getElementById('labelPajak');
        const displayPajak = document.getElementById('displayPajak');
        const displayTotalTagihan = document.getElementById('displayTotalTagihan');

        if (displaySubtotal) displaySubtotal.innerText = formatRupiah(subtotal);
        if (labelPajak) labelPajak.innerText = `Pajak (${pajakType} ${(pajakPersen * 100)}%):`;
        if (displayPajak) displayPajak.innerText = formatRupiah(nominalPajak);
        if (displayTotalTagihan) displayTotalTagihan.innerText = formatRupiah(grandTotal);
    }

    function restoreOldRows() {
        const container = document.getElementById('itemContainer');
        container.innerHTML = '';

        const obatIds = oldItemsData.master_obat_id || [];
        obatIds.forEach((obatId, index) => {
            const template = document.getElementById('rowTemplate').innerHTML;
            container.insertAdjacentHTML('beforeend', template);
            const row = container.lastElementChild;

            populateObatSelect(row, obatId);

            const selectObat = row.querySelector('.select-obat');
            const preBatch = oldItemsData.no_batch[index] || '';
            const qty = oldItemsData.jumlah[index] || 1;
            const harga = oldItemsData.harga_satuan[index] || 0;

            if (selectObat) {
                selectObat.value = obatId;
                onObatSelect(selectObat, preBatch);
            }

            const inputJumlah = row.querySelector('.input-jumlah');
            if (inputJumlah) {
                inputJumlah.value = qty;
                onJumlahChange(inputJumlah);
            }

            const inputHarga = row.querySelector('.input-harga');
            if (inputHarga) {
                inputHarga.value = harga;
            }

            updateRowSubtotal(row);
        });

        updateRemoveButtons();
        calculateTotal();
    }

    function handleSumberChange(val) {
        if (val) {
            window.location.href = "{{ route('pengeluaran.create') }}?permohonan_id=" + val;
        } else {
            window.location.href = "{{ route('pengeluaran.create') }}";
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        checkGudangNotice();
        const gudangId = document.getElementById('gudang_id').value;
        if (gudangId) {
            handleGudangChange(true);
        } else {
            // Placeholder empty row
            addItemRow();
        }

        // Form submit validation
        document.getElementById('formPengeluaran').addEventListener('submit', function (e) {
            const gudangId = document.getElementById('gudang_id').value;
            if (!gudangId) {
                e.preventDefault();
                alert('Silakan pilih Gudang Sumber terlebih dahulu!');
                document.getElementById('gudang_id').focus();
                return false;
            }

            const rows = document.querySelectorAll('.item-row');
            if (rows.length === 0) {
                e.preventDefault();
                alert('Harap tambahkan minimal 1 item obat / logistik!');
                return false;
            }

            let hasInvalid = false;
            rows.forEach(row => {
                const selectObat = row.querySelector('.select-obat');
                const selectBatch = row.querySelector('.select-batch');
                const inputJumlah = row.querySelector('.input-jumlah');

                if (!selectObat.value || !selectBatch.value || !inputJumlah.value || parseInt(inputJumlah.value) < 1) {
                    hasInvalid = true;
                }

                const maxStok = parseInt(inputJumlah.getAttribute('max')) || 0;
                if (maxStok > 0 && parseInt(inputJumlah.value) > maxStok) {
                    hasInvalid = true;
                }
            });

            if (hasInvalid) {
                e.preventDefault();
                alert('Terdapat item yang belum lengkap atau jumlah melebihi sisa stok yang tersedia. Harap periksa kembali form Anda.');
                return false;
            }

            const btnSubmit = document.getElementById('btnSubmit');
            if (btnSubmit) {
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses SBBK...';
            }
        });
    });
</script>
@endpush