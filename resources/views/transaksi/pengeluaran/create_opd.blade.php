@extends('layouts.app') 
@section('title', 'Catat Pengeluaran Obat Pelayanan - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Pencatatan Pengeluaran Obat Pelayanan</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pengeluaran.index') }}">Pengeluaran</a></li>
                            <li class="breadcrumb-item active">Tambah Pengeluaran OPD</li>
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
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold text-primary">
                        <i class="las la-dolly-flatbed me-1"></i> Formulir Pengeluaran Obat / Pelayanan Pasien
                    </h5>
                    <p class="text-muted mb-0 small">Catat pendistribusian obat dari fasilitas OPD ke unit internal (IGD, Poli, Rawat Inap), Pustu, atau Pasien.</p>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="las la-exclamation-circle me-1 fs-5 align-middle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="fw-bold mb-1"><i class="las la-exclamation-triangle me-1"></i> Periksa Isian Anda:</h6>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('pengeluaran.store') }}" method="POST" id="formPengeluaranOpd">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Nomor Bukti Pengeluaran <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $nomorSuratOtomatis) }}" required>
                                <small class="text-muted">Nomor surat keluar / register pengeluaran</small>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Tanggal Pengeluaran <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Tujuan Penyaluran / Penerima <span class="text-danger">*</span></label>
                                <input type="text" name="tujuan_pengeluaran" list="listTujuan" class="form-control" placeholder="Contoh: Poli Umum, IGD, Ruang Bersalin, Pustu Desa..." value="{{ old('tujuan_pengeluaran') }}" required>
                                <datalist id="listTujuan">
                                    <option value="Poli Umum">
                                    <option value="IGD (Instalasi Gawat Darurat)">
                                    <option value="Poli Gigi">
                                    <option value="Poli KIA / KB">
                                    <option value="Ruang Rawat Inap">
                                    <option value="Kamar Bersalin (VK)">
                                    <option value="Laboratorium">
                                    <option value="Pustu (Puskesmas Pembantu)">
                                    <option value="Poskesdes / Posyandu">
                                    <option value="Pelayanan Resep Pasien">
                                </datalist>
                                <small class="text-muted">Pilih atau ketik unit/pasien penerima</small>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Catatan / Keterangan Tambahan</label>
                                <input type="text" name="catatan" class="form-control" placeholder="Contoh: Resep rawat jalan / kebutuhan darurat tindakan / stok mingguan..." value="{{ old('catatan') }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark"><i class="las la-pills text-primary me-1"></i> Rincian Obat yang Dikeluarkan</h6>
                                <small class="text-muted">Tambahkan satu atau lebih item obat</small>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnTambahItem">
                                <i class="las la-plus me-1"></i> Tambah Item Obat
                            </button>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover align-middle" id="tabelItem">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 45%;">Nama Obat / Logistik <span class="text-danger">*</span></th>
                                        <th style="width: 25%;">No. Batch (Opsional)</th>
                                        <th style="width: 20%;" class="text-center">Jumlah Keluar <span class="text-danger">*</span></th>
                                        <th style="width: 10%;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemContainer">
                                    <tr class="item-row">
                                        <td>
                                            <select name="items[0][master_obat_id]" class="form-select select-obat" required>
                                                <option value="">-- Pilih Obat --</option>
                                                @foreach($masterObats as $mob)
                                                    <option value="{{ $mob->id }}">
                                                        {{ $mob->nama_obat }} ({{ $mob->satuan ?? 'Pcs' }}) {{ $mob->kode_obat ? '['.$mob->kode_obat.']' : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="items[0][no_batch]" class="form-control" placeholder="Contoh: BATCH-01 / -">
                                        </td>
                                        <td>
                                            <input type="number" name="items[0][jumlah]" class="form-control text-center input-jumlah" min="1" value="1" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-danger btn-sm btnHapusBaris" title="Hapus Baris" disabled>
                                                <i class="las la-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pengeluaran.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="las la-save me-1"></i> Simpan Pengeluaran
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
    let itemIndex = 1;
    const obatOptions = `@foreach($masterObats as $mob)<option value="{{ $mob->id }}">{{ addslashes($mob->nama_obat) }} ({{ $mob->satuan ?? 'Pcs' }}) {{ $mob->kode_obat ? '['.$mob->kode_obat.']' : '' }}</option>@endforeach`;

    $('#btnTambahItem').click(function() {
        const row = `
            <tr class="item-row">
                <td>
                    <select name="items[${itemIndex}][master_obat_id]" class="form-select select-obat" required>
                        <option value="">-- Pilih Obat --</option>
                        ${obatOptions}
                    </select>
                </td>
                <td>
                    <input type="text" name="items[${itemIndex}][no_batch]" class="form-control" placeholder="Contoh: BATCH-01 / -">
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][jumlah]" class="form-control text-center input-jumlah" min="1" value="1" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm btnHapusBaris" title="Hapus Baris">
                        <i class="las la-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#itemContainer').append(row);
        itemIndex++;
        updateHapusButtons();
    });

    $('body').on('click', '.btnHapusBaris', function() {
        if ($('.item-row').length > 1) {
            $(this).closest('tr').remove();
            updateHapusButtons();
        }
    });

    function updateHapusButtons() {
        if ($('.item-row').length <= 1) {
            $('.btnHapusBaris').prop('disabled', true);
        } else {
            $('.btnHapusBaris').prop('disabled', false);
        }
    }
</script>
@endpush
