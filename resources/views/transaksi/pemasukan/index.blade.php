@extends('layouts.app')
@section('title', 'Daftar Pemasukan - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Pesanan Pemasukan</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Daftar Pemasukan</li>
                        </ol>
                    </div>
                    <div class="col-auto align-self-center d-flex gap-2">
                        <!-- Dropdown Filter Semua Gudang -->
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

                        <!-- Tombol Tambahkan Pemasukan -->
                        <a href="{{ route('pemasukan.create') }}" class="btn btn-primary">
                            <i class="las la-plus me-1"></i> Tambahkan Pemasukan
                        </a>
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
                        <h5 class="fw-bold mb-0 text-primary">Daftar Pemasukan Barang</h5>
                        <div class="text-muted small">
                            Gunakan tabel di bawah untuk menampilkan dan mengelola hasil transaksi pemasukan.
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

                    <form action="{{ route('pemasukan.bulk-delete') }}" method="POST" id="formBulkDelete" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi yang ditandai?');">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40px;" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                        </th>
                                        <th style="width: 50px;">No</th>
                                        <th>Tanggal</th>
                                        <th>Nomor Surat</th>
                                        <th>Pemasok / Sumber</th>
                                        <th>Gudang Penerima</th>
                                        <th class="text-center">Total Item</th>
                                        <th>Catatan</th>
                                        <th style="width: 140px;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksis as $item)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="ids[]" value="{{ $item->id }}" class="form-check-input check-item">
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                        <td><span class="fw-semibold text-primary">{{ $item->nomor_surat }}</span></td>
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
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill">{{ $item->detail_transaksis_count ?? $item->detailTransaksis->count() }} Item</span>
                                        </td>
                                        <td>{{ Str::limit($item->catatan ?? '-', 35) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('pemasukan.show', $item->id) }}" class="btn btn-outline-info" title="Lihat Detail">
                                                    <i class="las la-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger" title="Hapus" onclick="deleteSingle('{{ route('pemasukan.destroy', $item->id) }}')">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">
                                            <i class="las la-inbox la-3x d-block mb-2"></i>
                                            Belum ada data transaksi pemasukan.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <button type="submit" id="btnBulkDelete" class="btn btn-danger btn-sm" disabled>
                                    <i class="las la-trash-alt me-1"></i> Hapus Data yang Ditandai (<span id="selectedCount">0</span>)
                                </button>
                            </div>
                            @if(method_exists($transaksis, 'links'))
                                <div>
                                    {{ $transaksis->links() }}
                                </div>
                            @endif
                        </div>
                    </form>

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
    document.addEventListener('DOMContentLoaded', function () {
        const checkAll = document.getElementById('checkAll');
        const checkItems = document.querySelectorAll('.check-item');
        const btnBulkDelete = document.getElementById('btnBulkDelete');
        const selectedCountSpan = document.getElementById('selectedCount');

        function updateBulkDeleteState() {
            const checkedCount = document.querySelectorAll('.check-item:checked').length;
            selectedCountSpan.textContent = checkedCount;
            if (checkedCount > 0) {
                btnBulkDelete.removeAttribute('disabled');
            } else {
                btnBulkDelete.setAttribute('disabled', 'disabled');
            }
        }

        if (checkAll) {
            checkAll.addEventListener('change', function () {
                checkItems.forEach(item => {
                    item.checked = checkAll.checked;
                });
                updateBulkDeleteState();
            });
        }

        checkItems.forEach(item => {
            item.addEventListener('change', function () {
                if (!item.checked) {
                    checkAll.checked = false;
                } else {
                    const allChecked = document.querySelectorAll('.check-item:checked').length === checkItems.length;
                    checkAll.checked = allChecked;
                }
                updateBulkDeleteState();
            });
        });
    });

    function deleteSingle(url) {
        if (confirm('Apakah Anda yakin ingin menghapus data transaksi pemasukan ini?')) {
            const form = document.getElementById('formSingleDelete');
            form.action = url;
            form.submit();
        }
    }
</script>
@endpush
