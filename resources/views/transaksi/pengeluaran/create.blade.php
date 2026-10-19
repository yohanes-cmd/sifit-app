@extends('layouts.app') 
@section('title', 'Tambah Pengeluaran - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tambahkan Pengeluaran Baru (SBBK)</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengeluaran Barang (SBBK)</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-primary">Form Surat Bukti Barang Keluar</h5>
                    <p class="text-muted mb-0 small">Catatan: Kalkulasi stok dan total akan diproses otomatis oleh sistem (Database Trigger).</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('pengeluaran.store') }}" method="POST" id="formPengeluaran">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Surat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 442/DINKES.7.2/" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Program <span class="text-danger">*</span></label>
                                <select class="form-select" name="program_id" required>
                                    <option value="">Pilih Program</option>
                                    @foreach($programs ?? [] as $program)
                                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>{{ $program->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gudang <span class="text-danger">*</span></label>
                                <select class="form-select" name="gudang_id" id="gudang_id" required>
                                    <option value="">Pilih Gudang</option>
                                    @foreach($gudangs as $gudang)
                                        <option value="{{ $gudang->id }}" {{ old('gudang_id') == $gudang->id ? 'selected' : '' }}>{{ $gudang->nama_gudang }} ({{ strtoupper($gudang->tipe) }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Pengangkut <span class="text-danger">*</span></label>
                                <select class="form-select" name="pengangkut_id" required>
                                    <option value="">Pilih Pengangkut</option>
                                    @foreach($pengangkuts ?? [] as $pengangkut)
                                        <option value="{{ $pengangkut->id }}" {{ old('pengangkut_id') == $pengangkut->id ? 'selected' : '' }}>{{ $pengangkut->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Instansi <span class="text-danger">*</span></label>
                                <select class="form-select" name="instansi_id" required>
                                    <option value="">Pilih Instansi</option>
                                    @foreach($instansis ?? [] as $instansi)
                                        <option value="{{ $instansi->id }}" {{ old('instansi_id') == $instansi->id ? 'selected' : '' }}>{{ $instansi->nama_opd }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-semibold">Pajak Invoice <span class="text-danger">*</span></label>
                                <select class="form-select" name="pajak_invoice" required>
                                    <option value="NO TAX" {{ old('pajak_invoice') == 'NO TAX' ? 'selected' : '' }}>No Tax</option>
                                    <option value="VAT" {{ old('pajak_invoice') == 'VAT' ? 'selected' : '' }}>VAT</option>
                                    <option value="GST" {{ old('pajak_invoice') == 'GST' ? 'selected' : '' }}>GST</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0"><i class="las la-boxes me-2"></i>Item pada Invoice</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItemRow()">
                                <i class="las la-plus me-1"></i> Tambah Item
                            </button>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle" id="tableItems">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 35%;">Nama Obat/Logistik <span class="text-danger">*</span></th>
                                        <th style="width: 15%;">Satuan</th>
                                        <th style="width: 15%;">Jumlah Keluar <span class="text-danger">*</span></th>
                                        <th style="width: 25%;">Harga Satuan <span class="text-danger">*</span></th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <tr class="item-row">
                                        <td>
                                            <select class="form-select select-obat" name="master_obat_id[]" required onchange="handleObatChange(this)">
                                                <option value="">Pilih Obat/Logistik</option>
                                                @foreach($masterObats as $obat)
                                                    <option value="{{ $obat->id }}" data-satuan="{{ $obat->satuan }}" data-harga="{{ (int)$obat->harga }}">
                                                        {{ $obat->nama_obat }} ({{ $obat->kode_obat }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control bg-light input-satuan" readonly placeholder="Otomatis">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control input-jumlah" name="jumlah[]" min="1" placeholder="Jumlah" required oninput="calculateTotal()">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control input-harga" name="harga_satuan[]" min="0" placeholder="0" required oninput="calculateTotal()">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" onclick="removeItemRow(this)">
                                                <i class="las la-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Catatan</label>
                                <textarea class="form-control" name="catatan" rows="4" placeholder="Catatan Intern / Catatan SBBK">{{ old('catatan') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2 row">
                                    <label class="col-sm-5 col-form-label fw-semibold">Total Item</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control bg-light" id="totalItemDisplay" readonly placeholder="Rp 0">
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-5 col-form-label fw-semibold">Biaya Kirim</label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control" name="biaya_kirim" id="biayaKirimInput" value="{{ old('biaya_kirim', 0) }}" min="0" oninput="calculateTotal()">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2 row">
                                    <label class="col-sm-5 col-form-label fw-bold">Total Tagihan</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control bg-light fw-bold text-primary" id="totalTagihanDisplay" readonly placeholder="Rp 0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-1"></i> Simpan SBBK
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
            <select class="form-select select-obat" name="master_obat_id[]" required onchange="handleObatChange(this)">
                <option value="">Pilih Obat/Logistik</option>
                @foreach($masterObats as $obat)
                    <option value="{{ $obat->id }}" data-satuan="{{ $obat->satuan }}" data-harga="{{ (int)$obat->harga }}">
                        {{ $obat->nama_obat }} ({{ $obat->kode_obat }})
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control bg-light input-satuan" readonly placeholder="Otomatis">
        </td>
        <td>
            <input type="number" class="form-control input-jumlah" name="jumlah[]" min="1" placeholder="Jumlah" required oninput="calculateTotal()">
        </td>
        <td>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control input-harga" name="harga_satuan[]" min="0" placeholder="0" required oninput="calculateTotal()">
            </div>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row" onclick="removeItemRow(this)">
                <i class="las la-trash"></i>
            </button>
        </td>
    </tr>
</template>

@endsection

@push('scripts')
<script>
    function handleObatChange(selectElem) {
        const row = selectElem.closest('tr');
        const selectedOption = selectElem.options[selectElem.selectedIndex];
        const satuan = selectedOption.getAttribute('data-satuan') || '';
        const harga = selectedOption.getAttribute('data-harga') || '';

        const inputSatuan = row.querySelector('.input-satuan');
        const inputHarga = row.querySelector('.input-harga');

        if (inputSatuan) inputSatuan.value = satuan;
        if (inputHarga && (!inputHarga.value || inputHarga.value == 0)) {
            inputHarga.value = harga || 0;
        }

        calculateTotal();
    }

    function addItemRow() {
        const template = document.getElementById('rowTemplate').innerHTML;
        document.getElementById('itemContainer').insertAdjacentHTML('beforeend', template);
        updateRemoveButtons();
    }

    function removeItemRow(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('tr').remove();
            updateRemoveButtons();
            calculateTotal();
        } else {
            alert('Minimal 1 item harus diisi.');
        }
    }

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(row => {
            const btn = row.querySelector('.btn-remove-row');
            if (rows.length === 1) {
                btn.setAttribute('disabled', 'disabled');
            } else {
                btn.removeAttribute('disabled');
            }
        });
    }

    function formatRupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    function calculateTotal() {
        let totalItem = 0;
        const rows = document.querySelectorAll('.item-row');

        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.input-jumlah')?.value) || 0;
            const harga = parseFloat(row.querySelector('.input-harga')?.value) || 0;
            totalItem += (qty * harga);
        });

        const biayaKirim = parseFloat(document.getElementById('biayaKirimInput')?.value) || 0;
        const grandTotal = totalItem + biayaKirim;

        const totalItemElem = document.getElementById('totalItemDisplay');
        const totalTagihanElem = document.getElementById('totalTagihanDisplay');
        if (totalItemElem) totalItemElem.value = formatRupiah(totalItem);
        if (totalTagihanElem) totalTagihanElem.value = formatRupiah(grandTotal);
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateRemoveButtons();
        calculateTotal();
    });
</script>
@endpush