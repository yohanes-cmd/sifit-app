@extends('layouts.app')
@section('title', 'Daftar Permohonan Obat - SIFIT')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="row">
                    <div class="col">
                        <h4 class="page-title">Permohonan Obat & Logistik</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Daftar Permohonan</li>
                        </ol>
                    </div>
                    @can('permohonan-create')
                    <div class="col-auto align-self-center">
                        <a href="{{ route('permohonan.create') }}" class="btn btn-primary">
                            <i class="las la-plus me-1"></i> Buat Permohonan Baru
                        </a>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6 mb-2">
            <div class="card shadow-sm border-0 mb-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avatar-md bg-light-primary text-primary rounded me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="las la-file-alt fs-2"></i>
                    </div>
                    <div>
                        <span class="text-muted small">Total Pengajuan</span>
                        <h4 class="mb-0 fw-bold">{{ $stats['total'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-2">
            <div class="card shadow-sm border-0 mb-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avatar-md bg-light-warning text-warning rounded me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="las la-clock fs-2"></i>
                    </div>
                    <div>
                        <span class="text-muted small">Menunggu Cek / Verifikasi</span>
                        <h4 class="mb-0 fw-bold">{{ $stats['menunggu'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-2">
            <div class="card shadow-sm border-0 mb-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avatar-md bg-light-info text-info rounded me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="las la-check fs-2"></i>
                    </div>
                    <div>
                        <span class="text-muted small">Disetujui (Acuan Barang)</span>
                        <h4 class="mb-0 fw-bold">{{ $stats['disetujui'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-2">
            <div class="card shadow-sm border-0 mb-0">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="avatar-md bg-light-success text-success rounded me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="las la-check-circle fs-2"></i>
                    </div>
                    <div>
                        <span class="text-muted small">Selesai (Sudah SBBK)</span>
                        <h4 class="mb-0 fw-bold">{{ $stats['selesai'] }}</h4>
                    </div>
                </div>
            </div>
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

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <form method="GET" action="{{ route('permohonan.index') }}" class="row g-2 align-items-center">
                        <div class="col-md-4 col-sm-12">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="las la-search"></i></span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nomor, keperluan, instansi..." value="{{ request('search') }}">
                            </div>
                        </div>

                        @if(!$user->isOpd())
                        <div class="col-md-3 col-sm-6">
                            <select name="opd_id" class="form-select">
                                <option value="">-- Semua OPD / Instansi --</option>
                                @foreach($opds as $opd)
                                    <option value="{{ $opd->id }}" {{ request('opd_id') == $opd->id ? 'selected' : '' }}>
                                        {{ $opd->nama_opd }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="col-md-3 col-sm-6">
                            <select name="status" class="form-select">
                                <option value="">-- Semua Status --</option>
                                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui (Siap SBBK)</option>
                                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12 d-flex gap-1">
                            <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                            <a href="{{ route('permohonan.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="las la-redo-alt"></i></a>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="4%">No</th>
                                    <th>Nomor Permohonan</th>
                                    <th>Tanggal</th>
                                    <th>Instansi Pemohon</th>
                                    <th>Keperluan / Program</th>
                                    <th class="text-center">Item Obat</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end" width="16%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permohonans as $index => $item)
                                    <tr>
                                        <td>{{ $permohonans->firstItem() + $index }}</td>
                                        <td>
                                            <a href="{{ route('permohonan.show', $item->id) }}" class="fw-bold text-primary">
                                                {{ $item->nomor_permohonan }}
                                            </a>
                                            @if($item->surat_pengantar)
                                                <span class="badge bg-light text-secondary ms-1" title="Ada Lampiran Surat"><i class="las la-paperclip"></i></span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_permohonan)->translatedFormat('d M Y') }}</td>
                                        <td>
                                            <span class="fw-semibold text-dark">{{ $item->opd->nama_opd ?? '-' }}</span>
                                            <small class="d-block text-muted">Pemohon: {{ $item->user->name ?? '-' }}</small>
                                        </td>
                                        <td>{{ $item->keperluan ?: '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border">
                                                {{ $item->detail_permohonans_count }} Jenis
                                            </span>
                                            <small class="d-block text-muted">{{ number_format($item->total_diminta) }} unit</small>
                                        </td>
                                        <td class="text-center">
                                            {!! $item->status_badge !!}
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('permohonan.show', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail & Acuan">
                                                    <i class="las la-eye"></i> Detail
                                                </a>

                                                @can('permohonan-print')
                                                <a href="{{ route('permohonan.print', $item->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Cetak Surat Permohonan">
                                                    <i class="las la-print"></i>
                                                </a>
                                                @endcan

                                                @can('pengeluaran-create')
                                                    @if(in_array($item->status, ['disetujui', 'menunggu']) && !$item->transaksi)
                                                        <a href="{{ route('pengeluaran.create', ['permohonan_id' => $item->id]) }}" class="btn btn-sm btn-success" title="Realisasikan ke SBBK">
                                                            <i class="las la-dolly"></i>
                                                        </a>
                                                    @endif
                                                @endcan

                                                @can('permohonan-delete')
                                                    @if($item->status !== 'selesai' && ($user->isSuperAdmin() || $item->status === 'menunggu'))
                                                        <form action="{{ route('permohonan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                                <i class="las la-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="las la-folder-open fs-1 d-block mb-2 text-secondary"></i>
                                            Belum ada permohonan obat yang diajukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($permohonans->hasPages())
                    <div class="card-footer bg-white border-top py-3 d-flex justify-content-end">
                        {{ $permohonans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
