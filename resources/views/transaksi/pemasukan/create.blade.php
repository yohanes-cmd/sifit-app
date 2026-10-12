@extends('layouts.app')
@section('title', 'Tambahkan Pemasukan - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Tambahkan Pemasukan</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pemasukan.index') }}">Daftar Pemasukan</a></li>
                            <li class="breadcrumb-item active">Tambahkan Pemasukan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-primary">Form Transaksi Pemasukan Barang</h5>
                    <small class="text-muted">Masukkan informasi yang kurang dibawah. Bagian bertanda <span class="text-danger">*</span> TIDAK BOLEH kosong.</small>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('pemasukan.store') }}" method="POST" id="formPemasukan">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Surat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 442/UPT-INSKER/2026" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Gudang Penerima <span class="text-danger">*</span></label>
                                <select class="form-select" name="gudang_tujuan_id" required>
                                    <option value="">-- Pilih Gudang --</option>
                                    @foreach($gudangs as $gudang)
                                        <option value="{{ $gudang->id }}" {{ old('gudang_tujuan_id') == $gudang->id ? 'selected' : '' }}>{{ $gudang->nama_gudang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Sumber / Pemasok</label>
                                <select class="form-select" name="pemasok_id">
                                    <option value="">-- Pilih Pemasok / Sumber --</option>
                                    @foreach($pemasoks as $pemasok)
                                        <option value="{{ $pemasok->id }}" {{ old('pemasok_id') == $pemasok->id ? 'selected' : '' }}>{{ $pemasok->nama_pemasok }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Catatan opsional mengenai pemasukan barang ini...">{{ old('catatan') }}</textarea>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0"><i class="las la-boxes me-2"></i>Item Pada Persediaan</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItemRow()">
                                <i class="las la-plus me-1"></i> Tambah Item
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="tableItems">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 35%;">Nama Obat / Logistik (Kode) <span class="text-danger">*</span></th>
                                        <th style="width: 25%;">Nomor Batch <span class="text-danger">*</span></th>
                                        <th style="width: 20%;">Tanggal Kadaluarsa <span class="text-danger">*</span></th>
                                        <th style="width: 15%;">Jumlah Barang <span class="text-danger">*</span></th>
                                        <th style="width: 5%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <!-- Dynamic rows inserted via JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('pemasukan.index') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="las la-save me-1"></i> Kirim / Simpan Pemasukan
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
            <select class="form-select select-obat" name="items[{INDEX}][master_obat_id]" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($masterObats as $obat)
                    <option value="{{ $obat->id }}">{{ $obat->nama_obat }} ({{ $obat->kode_obat }}) - {{ $obat->satuan }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control" name="items[{INDEX}][no_batch]" placeholder="Contoh: BATCH-001" required>
        </td>
        <td>
            <input type="date" class="form-control" name="items[{INDEX}][exp_date]" required>
        </td>
        <td>
            <input type="number" class="form-control" name="items[{INDEX}][jumlah]" min="1" placeholder="Jumlah" required>
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
    let itemIndex = 0;

    function addItemRow() {
        const template = document.getElementById('rowTemplate').innerHTML;
        const newRowHtml = template.replace(/{INDEX}/g, itemIndex);
        document.getElementById('itemContainer').insertAdjacentHTML('beforeend', newRowHtml);
        itemIndex++;
        updateRemoveButtons();
    }

    function removeItemRow(btn) {
        const rows = document.querySelectorAll('.item-row');
        if (rows.length > 1) {
            btn.closest('tr').remove();
            updateRemoveButtons();
        } else {
            alert('Minimal 1 item barang harus diisi.');
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

    document.addEventListener('DOMContentLoaded', function () {
        addItemRow();
    });
</script>
@endpush