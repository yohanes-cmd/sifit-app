@extends('layouts.app')
@section('title', 'Tambah Pemindahan - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Transaksi Pemindahan Antar Gudang</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pemindahan.index') }}">Pemindahan Barang</a></li>
                            <li class="breadcrumb-item active">Tambah Pemindahan</li>
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
                    <h5 class="card-title mb-0 fw-bold text-primary">Form Surat Pemindahan Barang</h5>
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

                    <form action="{{ route('pemindahan.store') }}" method="POST" id="formPemindahan">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Transfer <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nomor Surat Pemindahan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: TR-2026-001" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Dari Gudang (Asal) <span class="text-danger">*</span></label>
                                <select class="form-select" name="gudang_asal_id" id="gudang_asal_id" required>
                                    <option value="">-- Pilih Gudang Sumber --</option>
                                    @foreach($gudangs as $gudang)
                                        <option value="{{ $gudang->id }}" {{ old('gudang_asal_id') == $gudang->id ? 'selected' : '' }}>{{ $gudang->nama_gudang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Ke Gudang (Tujuan) <span class="text-danger">*</span></label>
                                <select class="form-select" name="gudang_tujuan_id" id="gudang_tujuan_id" required>
                                    <option value="">-- Pilih Gudang Penerima --</option>
                                    @foreach($gudangs as $gudang)
                                        <option value="{{ $gudang->id }}" {{ old('gudang_tujuan_id') == $gudang->id ? 'selected' : '' }}>{{ $gudang->nama_gudang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Catatan / Keterangan</label>
                            <textarea class="form-control" name="catatan" rows="2" placeholder="Catatan opsional mengenai surat pemindahan ini...">{{ old('catatan') }}</textarea>
                        </div>

                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0"><i class="las la-boxes me-2"></i>Daftar Item Barang dipindahkan</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addItemRow()">
                                <i class="las la-plus me-1"></i> Tambah Item
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle" id="tableItems">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 45%;">Pilih Master Obat / Logistik <span class="text-danger">*</span></th>
                                        <th style="width: 25%;">Nomor Batch <span class="text-danger">*</span></th>
                                        <th style="width: 20%;">Jumlah (Qty) <span class="text-danger">*</span></th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <!-- Dynamic rows will be inserted here -->
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('pemindahan.index') }}" class="btn btn-secondary">
                                <i class="las la-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="las la-save me-1"></i> Simpan Transaksi Pemindahan
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
                    <option value="{{ $obat->id }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control" name="items[{INDEX}][no_batch]" placeholder="Contoh: BATCH001" required>
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

    document.addEventListener('DOMContentLoaded', function () {
        // Add initial row
        addItemRow();

        // Form submit validation
        document.getElementById('formPemindahan').addEventListener('submit', function (e) {
            const asal = document.getElementById('gudang_asal_id').value;
            const tujuan = document.getElementById('gudang_tujuan_id').value;

            if (asal && tujuan && asal === tujuan) {
                e.preventDefault();
                alert('Gudang Asal dan Gudang Tujuan tidak boleh sama!');
                return false;
            }
        });
    });
</script>
@endpush