@php
    $currentUser = auth()->user();
    $isOpd = isset($isOpd) ? $isOpd : ($currentUser && $currentUser->isAdminOpd());
@endphp

@extends('layouts.app')
@section('title', ($isOpd ? 'Penerimaan Obat OPD' : 'Daftar Pemasukan') . ' - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">{{ $isOpd ? 'Pemasukan & Penerimaan Obat OPD' : 'Pesanan Pemasukan' }}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Daftar Pemasukan</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center d-flex gap-2">
                        @if($isOpd)
                            <span class="badge bg-primary fs-6 px-3 py-2 d-flex align-items-center">
                                <i class="las la-hospital fs-5 me-1"></i> {{ auth()->user()->opdInstansi->nama_opd ?? auth()->user()->opd ?? 'OPD' }}
                            </span>
                        @else
                            <!-- Dropdown Filter Semua Gudang (Super Admin) -->
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownGudang" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="las la-warehouse me-1"></i>
                                    @if($selectedGudang)
                                        {{ $gudangs->firstWhere('id', $selectedGudang)->nama_gudang ?? 'Semua Gudang' }}
                                    @else
                                        Semua Gudang
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownGudang">
                                    <li>
                                        <a class="dropdown-item {{ !$selectedGudang ? 'active' : '' }}" href="{{ route('pemasukan.index') }}">
                                            Semua Gudang
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    @foreach($gudangs as $gudang)
                                        <li>
                                            <a class="dropdown-item {{ $selectedGudang == $gudang->id ? 'active' : '' }}" href="{{ route('pemasukan.index', ['gudang_id' => $gudang->id]) }}">
                                                {{ $gudang->nama_gudang }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Tombol Tambahkan Pemasukan (Super Admin) -->
                            @can('pemasukan-create')
                            <a href="{{ route('pemasukan.create') }}" class="btn btn-primary">
                                <i class="las la-plus me-1"></i> Tambahkan Pemasukan
                            </a>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-primary">
                            <i class="las la-truck-loading me-1"></i> {{ $isOpd ? 'Daftar Barang Masuk dari Gudang Farmasi Pusat' : 'Daftar Pemasukan Barang' }}
                        </h5>
                        <div class="text-muted small">
                            {{ $isOpd ? 'Seluruh realisasi obat dari permohonan yang disetujui tercatat otomatis di sini sebagai pemasukan OPD.' : 'Gunakan tabel di bawah untuk menampilkan dan mengelola hasil transaksi pemasukan gudang pusat.' }}
                        </div>
                    </div>

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

                    @if(!$isOpd)
                    <form action="{{ route('pemasukan.bulk-delete') }}" method="POST" id="formBulkDelete" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi yang ditandai?');">
                        @csrf
                    @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        @if(!$isOpd)
                                        <th style="width: 40px;" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                        </th>
                                        @endif
                                        <th style="width: 50px;" class="text-center">No</th>
                                        <th>Tanggal Penerimaan</th>
                                        <th>Nomor Surat / SBBK</th>
                                        @if($isOpd)
                                            <th>Sumber Pengirim</th>
                                            <th>Acuan Permohonan</th>
                                        @else
                                            <th>Pemasok / Sumber</th>
                                            <th>Gudang Penerima</th>
                                        @endif
                                        <th class="text-center">Total Item</th>
                                        <th>Catatan</th>
                                        <th style="width: 140px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksis as $item)
                                    <tr>
                                        @if(!$isOpd)
                                        <td class="text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="form-check-input check-item">
                                        </td>
                                        @endif
                                        <td class="text-center">{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('pemasukan.show', $item->id) }}" class="fw-semibold text-primary">
                                                {{ $item->nomor_surat }}
                                            </a>
                                        </td>

                                        @if($isOpd)
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <i class="las la-warehouse me-1"></i>{{ $item->gudangAsal->nama_gudang ?? 'Gudang Farmasi Pusat' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($item->permohonan)
                                                    <a href="{{ route('permohonan.show', $item->permohonan_id) }}" class="badge bg-info text-dark">
                                                        <i class="las la-file-alt me-1"></i>{{ $item->permohonan->nomor_permohonan }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Penyaluran Reguler</span>
                                                @endif
                                            </td>
                                        @else
                                            <td>
                                                @if($item->pemasok)
                                                    <span class="badge bg-info text-dark">
                                                        <i class="las la-building me-1"></i>{{ $item->pemasok->nama_pemasok }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="las la-warehouse me-1"></i>{{ $item->gudangTujuan->nama_gudang ?? '-' }}
                                                </span>
                                            </td>
                                        @endif

                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill">{{ $item->detail_transaksis_count ?? $item->detailTransaksis->count() }} Jenis</span>
                                        </td>
                                        <td>{{ Str::limit($item->catatan ?? '-', 35) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('pemasukan.show', $item->id) }}" class="btn btn-outline-info" title="Lihat Detail Penerimaan">
                                                    <i class="las la-eye"></i> Detail
                                                </a>
                                                @if($isOpd)
                                                    <a href="{{ route('pengeluaran.show', $item->id) }}" target="_blank" class="btn btn-outline-secondary" title="Cetak Dokumen SBBK / Bukti Terima">
                                                        <i class="las la-print"></i>
                                                    </a>
                                                @else
                                                    @can('pemasukan-delete')
                                                    <button type="button" class="btn btn-outline-danger" title="Hapus" onclick="deleteSingle('{{ route('pemasukan.destroy', $item->id) }}')">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="{{ $isOpd ? 8 : 9 }}" class="text-center py-5 text-muted">
                                            <i class="las la-truck-loading la-3x d-block mb-2 text-secondary"></i>
                                            Belum ada data barang masuk / pemasukan obat.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    @if(!$isOpd)
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button type="submit" class="btn btn-danger btn-sm" id="btnBulkDelete" disabled>
                                <i class="las la-trash"></i> Hapus Terpilih
                            </button>
                            {{ $transaksis->links() }}
                        </div>
                    </form>
                    @else
                        <div class="d-flex justify-content-end mt-3">
                            {{ $transaksis->links() }}
                        </div>
                    @endif

                    <!-- Hidden single delete form -->
                    <form id="formSingleDelete" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#checkAll').change(function() {
        $('.check-item').prop('checked', $(this).prop('checked'));
        updateBulkDeleteButton();
    });

    $('body').on('change', '.check-item', function() {
        updateBulkDeleteButton();
    });

    function updateBulkDeleteButton() {
        var count = $('.check-item:checked').length;
        if (count > 0) {
            $('#btnBulkDelete').prop('disabled', false).text('Hapus Terpilih (' + count + ')');
        } else {
            $('#btnBulkDelete').prop('disabled', true).text('Hapus Terpilih');
        }
    }

    function deleteSingle(url) {
        if (confirm('Apakah Anda yakin ingin menghapus transaksi pemasukan ini?')) {
            const form = document.getElementById('formSingleDelete');
            form.action = url;
            form.submit();
        }
    }
</script>
@endpush
