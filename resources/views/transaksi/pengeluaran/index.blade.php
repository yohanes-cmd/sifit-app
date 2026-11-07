@php
    $currentUser = auth()->user();
    $isOpd = isset($isOpd) ? $isOpd : ($currentUser && $currentUser->isAdminOpd());
@endphp

@extends('layouts.app')
@section('title', ($isOpd ? 'Pengeluaran Obat OPD' : 'Daftar Pengeluaran (SBBK)') . ' - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">{{ $isOpd ? 'Pengeluaran Obat Pelayanan OPD' : 'Pengeluaran Barang (SBBK)' }}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengeluaran Barang</li>
                        </ol>
                    </div>
                    @can('pengeluaran-create')
                    <div class="col-auto align-self-center">
                        <a href="{{ route('pengeluaran.create') }}" class="btn btn-primary">
                            <i class="las la-plus me-1"></i> {{ $isOpd ? 'Catat Pengeluaran Baru' : 'Tambah Pengeluaran (SBBK)' }}
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-primary">
                                <i class="las la-dolly-flatbed me-1"></i> {{ $isOpd ? 'Daftar Penyaluran Obat ke Unit Pelayanan / Pasien' : 'Daftar Surat Bukti Barang Keluar (SBBK)' }}
                            </h5>
                            <p class="text-muted small mb-0 mt-1">
                                {{ $isOpd ? 'Mencatat pengeluaran obat untuk pelayanan kesehatan di lingkungan OPD / Puskesmas.' : 'Pengeluaran obat dari Gudang Farmasi Pusat kepada instansi pemohon.' }}
                            </p>
                        </div>
                    </div>

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

                    <!-- Filter dan Pencarian -->
                    <form method="GET" action="{{ route('pengeluaran.index') }}" class="row g-2 mb-4">
                        @if(!$isOpd)
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="las la-warehouse"></i></span>
                                <select class="form-select" name="gudang_id" onchange="this.form.submit()">
                                    <option value="">Semua Gudang Sumber</option>
                                    @foreach($gudangs as $g)
                                        <option value="{{ $g->id }}" {{ request('gudang_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama_gudang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="{{ $isOpd ? 'col-md-8' : 'col-md-6' }}">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="{{ $isOpd ? 'Cari nomor bukti, keperluan, atau catatan...' : 'Cari nomor surat, penerima/instansi, program, atau catatan...' }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="las la-search me-1"></i> Cari
                                </button>
                                @if(request()->hasAny(['gudang_id', 'search']))
                                    <a href="{{ route('pengeluaran.index') }}" class="btn btn-outline-secondary">
                                        <i class="las la-redo"></i> Reset
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Tanggal</th>
                                    <th>Nomor Bukti / Surat</th>
                                    @if($isOpd)
                                        <th>Tujuan / Penerima</th>
                                        <th>Kategori</th>
                                    @else
                                        <th>Gudang Sumber</th>
                                        <th>Instansi Penerima</th>
                                        <th>Program</th>
                                    @endif
                                    <th class="text-center">Item Obat</th>
                                    @if(!$isOpd)
                                        <th class="text-end">Total Nilai (Rp)</th>
                                    @endif
                                    <th style="width: 130px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('pengeluaran.show', $item->id) }}" class="fw-bold text-primary text-decoration-none">
                                            {{ $item->nomor_surat }}
                                        </a>
                                    </td>

                                    @if($isOpd)
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item->catatan ?: 'Pelayanan Pasien' }}</span>
                                        </td>
                                        <td>
                                            @if(is_null($item->gudang_asal_id))
                                                <span class="badge bg-success"><i class="las la-hospital-user me-1"></i>Distribusi OPD</span>
                                            @else
                                                <span class="badge bg-secondary"><i class="las la-warehouse me-1"></i>SBBK Pusat</span>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge bg-secondary">
                                                <i class="las la-warehouse me-1"></i>{{ $item->gudangAsal->nama_gudang ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item->instansi->nama_opd ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info border">
                                                {{ $item->program->nama ?? '-' }}
                                            </span>
                                        </td>
                                    @endif

                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill">{{ $item->detail_transaksis_count ?? $item->detailTransaksis->count() }} Jenis</span>
                                    </td>

                                    @if(!$isOpd)
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($item->grand_total, 0, ',', '.') }}
                                    </td>
                                    @endif

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('pengeluaran.show', $item->id) }}" class="btn btn-outline-info" title="Lihat SBBK / Cetak">
                                                <i class="las la-print"></i> Detail
                                            </a>
                                            @if(!$isOpd || is_null($item->gudang_asal_id))
                                                @can('pengeluaran-delete')
                                                <button type="button" class="btn btn-outline-danger" title="Hapus" onclick="deleteSingle('{{ route('pengeluaran.destroy', $item->id) }}', '{{ $item->nomor_surat }}')">
                                                    <i class="las la-trash"></i>
                                                </button>
                                                @endcan
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ $isOpd ? 7 : 9 }}" class="text-center py-5 text-muted">
                                        <i class="las la-dolly la-3x d-block mb-2 text-secondary"></i>
                                        Belum ada data transaksi pengeluaran barang.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($transaksis, 'links'))
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
    function deleteSingle(url, nomorSurat) {
        if (confirm(`Apakah Anda yakin ingin menghapus data pengeluaran: ${nomorSurat}?`)) {
            const form = document.getElementById('formSingleDelete');
            form.action = url;
            form.submit();
        }
    }
</script>
@endpush
